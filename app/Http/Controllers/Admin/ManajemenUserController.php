<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\DosenProfile;
use App\Models\Prodi;
use App\Imports\MahasiswaImport;
use App\Imports\DosenImport;
use App\Exports\DosenMahasiswaExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ManajemenUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with(['mahasiswaProfile', 'dosenProfile']);

        // Filter by role (default: all)
        $role = $request->get('role', 'all');
        if ($role != 'all' && in_array($role, ['admin', 'dosen', 'mahasiswa'])) {
            $query->where('role', $role);
        }

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('username', 'like', '%' . $search . '%')
                  ->orWhere('nim', 'like', '%' . $search . '%')
                  ->orWhere('nidn', 'like', '%' . $search . '%')
                  ->orWhere('role', 'like', '%' . $search . '%');
            });
        }

        // Pagination with entries per page
        $perPage = $request->get('entries', 10);
        $users = $query->orderBy('created_at', 'desc')->paginate($perPage);

        // Append query parameters to pagination links
        $users->appends($request->only(['search', 'entries', 'role']));

        // Count per role for badge display
        $counts = [
            'all' => User::count(),
            'admin' => User::where('role', 'admin')->count(),
            'dosen' => User::where('role', 'dosen')->count(),
            'mahasiswa' => User::where('role', 'mahasiswa')->count(),
        ];

        return view('admin.manajemenUser.index', compact('users', 'role', 'counts'));
    }

    public function create()
    {
        $roles = ['admin', 'dosen', 'mahasiswa'];
        $prodis = Prodi::orderBy('nama_prodi')->get(); // Tambahkan ini
        return view('admin.manajemenUser.create', compact('roles', 'prodis')); // Tambahkan prodis
    }

    public function store(Request $request)
    {
        try {
            \Log::info('=== START REQUEST ===');
            \Log::info('Role selected:', ['role' => $request->role]);
            \Log::info('All request data:', $request->except(['password', 'password_confirmation']));
            
            // Validasi berdasarkan role
            $rules = $this->getValidationRules($request->role);
            \Log::info('Validation rules:', $rules);
            
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                \Log::error('Validation failed:', $validator->errors()->toArray());
                
                // Show detailed error
                $errorMessages = [];
                foreach ($validator->errors()->all() as $message) {
                    $errorMessages[] = $message;
                }
                
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with('error', 'Validasi gagal! Error: ' . implode(', ', $errorMessages));
            }

            DB::beginTransaction();

            try {
                // Handle file upload if exists
                $pasFotoPath = null;
                if ($request->hasFile('pas_foto')) {
                    $pasFotoPath = $request->file('pas_foto')->store('pas_foto', 'public');
                    \Log::info('File uploaded:', ['path' => $pasFotoPath]);
                }

                // Create user based on role
                $userData = $this->prepareUserData($request);
                \Log::info('User data prepared:', $userData);
                
                $user = User::create($userData);
                \Log::info('User created:', ['id' => $user->id, 'role' => $user->role]);

                // Create role-specific profile
                if ($request->role === 'mahasiswa') {
                    $this->createMahasiswaProfile($user, $request, $pasFotoPath);
                } elseif ($request->role === 'dosen') {
                    $this->createDosenProfile($user, $request, $pasFotoPath);
                }

                DB::commit();
                \Log::info('=== TRANSACTION COMMITTED ===');

                return redirect()
                    ->route('admin.manajemen-user.index')
                    ->with('success', 'User ' . ucfirst($request->role) . ' berhasil ditambahkan!');

            } catch (\Exception $e) {
                DB::rollBack();
                \Log::error('Transaction error:', [
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString()
                ]);

                // Delete uploaded file if exists
                if ($pasFotoPath) {
                    Storage::disk('public')->delete($pasFotoPath);
                }

                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
            }

        } catch (\Exception $e) {
            \Log::error('Controller error:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    public function show(User $user)
    {
        try {
            // Load relasi yang diperlukan
            $user->load(['mahasiswaProfile', 'dosenProfile']);
            
            \Log::info('Show user detail:', [
                'user_id' => $user->id,
                'role' => $user->role,
                'has_mahasiswa_profile' => $user->mahasiswaProfile !== null,
                'has_dosen_profile' => $user->dosenProfile !== null
            ]);
            
            return view('admin.manajemenUser.show', compact('user'));
            
        } catch (\Exception $e) {
            \Log::error('Show error:', [
                'message' => $e->getMessage(),
                'user_id' => $user->id
            ]);
            
            return redirect()
                ->route('admin.manajemen-user.index')
                ->with('error', 'Gagal menampilkan detail user: ' . $e->getMessage());
        }
    }

    public function edit(User $user)
    {
        $prodis = Prodi::orderBy('nama_prodi')->get(); // Tambahkan ini
        return view('admin.manajemenUser.edit', compact('user', 'prodis'));
    }

    public function update(Request $request, User $user)
    {
        try {
            \Log::info('=== UPDATE USER START ===');
            \Log::info('User ID:', ['id' => $user->id, 'role' => $user->role]);
            \Log::info('Request data:', $request->except(['password', 'password_confirmation']));

            DB::beginTransaction();

            try {
                // Update berdasarkan role
                if ($user->role === 'admin') {
                    $this->updateAdmin($request, $user);
                } elseif ($user->role === 'dosen') {
                    $this->updateDosen($request, $user);
                } elseif ($user->role === 'mahasiswa') {
                    $this->updateMahasiswa($request, $user);
                }

                DB::commit();
                \Log::info('=== UPDATE SUCCESS ===');

                return redirect()
                    ->route('admin.manajemen-user.index')
                    ->with('success', 'Data user berhasil diperbarui!');

            } catch (\Exception $e) {
                DB::rollBack();
                \Log::error('Update transaction error:', [
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine()
                ]);

                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
            }

        } catch (\Exception $e) {
            \Log::error('Update controller error:', [
                'message' => $e->getMessage()
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    public function destroy(User $user)
    {
        try {
            \Log::info('=== DELETE USER START ===');
            \Log::info('User to delete:', [
                'id' => $user->id,
                'name' => $user->name,
                'role' => $user->role
            ]);

            DB::beginTransaction();

            try {
                // Delete photo if exists
                if ($user->role === 'mahasiswa' && $user->mahasiswaProfile && $user->mahasiswaProfile->pas_foto) {
                    Storage::disk('public')->delete($user->mahasiswaProfile->pas_foto);
                    \Log::info('Deleted mahasiswa photo');
                } elseif ($user->role === 'dosen' && $user->dosenProfile && $user->dosenProfile->pas_foto) {
                    Storage::disk('public')->delete($user->dosenProfile->pas_foto);
                    \Log::info('Deleted dosen photo');
                }

                // Delete profile first (due to foreign key)
                if ($user->role === 'mahasiswa' && $user->mahasiswaProfile) {
                    $user->mahasiswaProfile->delete();
                    \Log::info('Mahasiswa profile deleted');
                } elseif ($user->role === 'dosen' && $user->dosenProfile) {
                    $user->dosenProfile->delete();
                    \Log::info('Dosen profile deleted');
                }

                // Delete user
                $userName = $user->name;
                $user->delete();
                \Log::info('User deleted successfully');

                DB::commit();
                \Log::info('=== DELETE SUCCESS ===');

                return redirect()
                    ->route('admin.manajemen-user.index')
                    ->with('success', 'User "' . $userName . '" berhasil dihapus!');

            } catch (\Exception $e) {
                DB::rollBack();
                \Log::error('Delete transaction error:', [
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine()
                ]);

                return redirect()
                    ->route('admin.manajemen-user.index')
                    ->with('error', 'Gagal menghapus user: ' . $e->getMessage());
            }

        } catch (\Exception $e) {
            \Log::error('Delete controller error:', [
                'message' => $e->getMessage()
            ]);

            return redirect()
                ->route('admin.manajemen-user.index')
                ->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    // ==================== PRIVATE METHODS ====================

    private function updateAdmin(Request $request, User $user)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            throw new \Exception('Validasi gagal: ' . implode(', ', $validator->errors()->all()));
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();
        \Log::info('Admin updated successfully');
    }

    private function updateDosen(Request $request, User $user)
    {
        $rules = [
            'nama_lengkap_dosen' => 'required|string|max:150',
            'nidn' => 'required|string|max:50|unique:users,nidn,' . $user->id . '|unique:dosen_profiles,nidn,' . ($user->dosenProfile->id ?? 'NULL'),
            'email' => 'required|email|max:150|unique:users,email,' . $user->id,
            'program_studi' => 'nullable|string|max:100',
            'no_telp' => 'nullable|string|max:20',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'agama' => 'nullable|string|max:50',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'pas_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'password' => 'nullable|min:6|confirmed',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            throw new \Exception('Validasi gagal: ' . implode(', ', $validator->errors()->all()));
        }

        // Update user table
        $user->name = $request->nama_lengkap_dosen;
        $user->email = $request->email;
        $user->nidn = $request->nidn;
        $user->username = $request->nidn;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Update dosen profile
        $dosenData = [
            'nama_lengkap' => $request->nama_lengkap_dosen,
            'nidn' => $request->nidn,
            'email' => $request->email,
            'program_studi' => $request->program_studi,
            'no_telp' => $request->no_telp,
            'jenis_kelamin' => $request->jenis_kelamin,
            'agama' => $request->agama,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
        ];

        // Handle photo upload
        if ($request->hasFile('pas_foto')) {
            // Delete old photo
            if ($user->dosenProfile && $user->dosenProfile->pas_foto) {
                Storage::disk('public')->delete($user->dosenProfile->pas_foto);
            }
            $dosenData['pas_foto'] = $request->file('pas_foto')->store('pas_foto', 'public');
        }

        if ($user->dosenProfile) {
            $user->dosenProfile->update($dosenData);
        } else {
            $dosenData['user_id'] = $user->id;
            DosenProfile::create($dosenData);
        }

        \Log::info('Dosen updated successfully');
    }

    private function updateMahasiswa(Request $request, User $user)
    {
        $rules = [
            'nama_lengkap_mhs' => 'required|string|max:150',
            'nim' => 'required|string|max:50|unique:users,nim,' . $user->id . '|unique:mahasiswa_profiles,nim,' . ($user->mahasiswaProfile->id ?? 'NULL'),
            'email' => 'required|email|max:150|unique:users,email,' . $user->id,
            'nik' => 'nullable|string|max:50',
            'no_telp_mhs' => 'nullable|string|max:20',
            'prodi_id' => 'nullable|exists:prodi,id',
            'semester' => 'nullable|integer|min:1|max:14',
            'jenis_kelamin_mhs' => 'nullable|in:Laki-laki,Perempuan',
            'agama_mhs' => 'nullable|string|max:50',
            'tempat_lahir_mhs' => 'nullable|string|max:100',
            'tanggal_lahir_mhs' => 'nullable|date',
            'tanggal_masuk' => 'nullable|date',
            'alamat_mhs' => 'nullable|string',
            'biaya_masuk' => 'nullable|numeric|min:0',
            'status_mahasiswa' => 'nullable|in:Aktif,Tidak Aktif',
            'status_sync' => 'nullable|in:Sudah Sync,Belum Sync',
            'pas_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'password' => 'nullable|min:6|confirmed',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            throw new \Exception('Validasi gagal: ' . implode(', ', $validator->errors()->all()));
        }

        // Update user table
        $user->name = $request->nama_lengkap_mhs;
        $user->email = $request->email;
        $user->nim = $request->nim;
        $user->username = $request->nim;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Update mahasiswa profile
        $mahasiswaData = [
            'nama_lengkap' => $request->nama_lengkap_mhs,
            'nim' => $request->nim,
            'email' => $request->email,
            'nik' => $request->nik,
            'no_telp' => $request->no_telp_mhs,
            'prodi_id' => $request->prodi_id,
            'semester' => $request->semester,
            'jenis_kelamin' => $request->jenis_kelamin_mhs,
            'agama' => $request->agama_mhs,
            'tempat_lahir' => $request->tempat_lahir_mhs,
            'tanggal_lahir' => $request->tanggal_lahir_mhs,
            'tanggal_masuk' => $request->tanggal_masuk,
            'alamat' => $request->alamat_mhs,
            'biaya_masuk' => round($request->biaya_masuk, 2),
            'status_mahasiswa' => $request->status_mahasiswa ?? 'Aktif',
            'status_sync' => $request->status_sync ?? 'Belum Sync',
        ];

        // Handle photo upload
        if ($request->hasFile('pas_foto')) {
            // Delete old photo
            if ($user->mahasiswaProfile && $user->mahasiswaProfile->pas_foto) {
                Storage::disk('public')->delete($user->mahasiswaProfile->pas_foto);
            }
            $mahasiswaData['pas_foto'] = $request->file('pas_foto')->store('pas_foto', 'public');
        }

        if ($user->mahasiswaProfile) {
            $user->mahasiswaProfile->update($mahasiswaData);
        } else {
            $mahasiswaData['user_id'] = $user->id;
            Mahasiswa::create($mahasiswaData);
        }

        \Log::info('Mahasiswa updated successfully');
    }

    private function getValidationRules($role, $userId = null)
    {
        $baseRules = [
            'role' => 'required|in:admin,dosen,mahasiswa',
            'password' => 'required|min:6|confirmed'
        ];

        switch ($role) {
            case 'admin':
                return array_merge($baseRules, [
                    'name' => 'required|string|max:255',
                    'email' => 'required|email|max:255|unique:users,email' . ($userId ? ',' . $userId : ''),
                ]);

            case 'dosen':
                return array_merge($baseRules, [
                    'nama_lengkap_dosen' => 'required|string|max:150',
                    'nidn' => 'required|string|max:50|unique:users,nidn|unique:dosen_profiles,nidn',
                    'email' => 'required|email|max:150|unique:users,email',
                    'program_studi' => 'nullable|string|max:100',
                    'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
                    'tempat_lahir' => 'nullable|string|max:100',
                    'tanggal_lahir' => 'nullable|date',
                    'agama' => 'nullable|string|max:50',
                    'alamat' => 'nullable|string',
                    'no_telp' => 'nullable|string|max:20',
                    'pas_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                ]);

            case 'mahasiswa':
                return array_merge($baseRules, [
                    'nama_lengkap_mhs' => 'required|string|max:150',
                    'nim' => 'required|string|max:50|unique:users,nim|unique:mahasiswa_profiles,nim',
                    'nik' => 'nullable|string|max:50',
                    'email' => 'required|email|max:150|unique:users,email',
                    'prodi_id' => 'required|exists:prodi,id', // Tambahkan validasi ini
                    'program_studi_mhs' => 'nullable|string|max:100',
                    'semester' => 'nullable|integer|min:1|max:14',
                    'jenis_kelamin_mhs' => 'nullable|in:Laki-laki,Perempuan',
                    'tempat_lahir_mhs' => 'nullable|string|max:100',
                    'tanggal_lahir_mhs' => 'nullable|date',
                    'tanggal_masuk' => 'nullable|date',
                    'agama_mhs' => 'nullable|string|max:50',
                    'alamat_mhs' => 'nullable|string',
                    'no_telp_mhs' => 'nullable|string|max:20',
                    'biaya_masuk' => 'nullable|numeric|min:0',
                    'status_mahasiswa' => 'nullable|in:Aktif,Tidak Aktif',
                    'status_sync' => 'nullable|in:Sudah Sync,Belum Sync',
                    'pas_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                ]);

            default:
                return $baseRules;
        }
    }

    private function prepareUserData(Request $request)
    {
        $userData = [
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ];

        switch ($request->role) {
            case 'admin':
                $userData['name'] = $request->name;
                $userData['username'] = $request->email;
                $userData['email'] = $request->email;
                break;

            case 'dosen':
                $userData['name'] = $request->nama_lengkap_dosen;
                $userData['username'] = $request->nidn;
                $userData['email'] = $request->email;
                $userData['nidn'] = $request->nidn;
                break;

            case 'mahasiswa':
                $userData['name'] = $request->nama_lengkap_mhs;
                $userData['username'] = $request->nim;
                $userData['email'] = $request->email;
                $userData['nim'] = $request->nim;
                break;
        }

        return $userData;
    }

    private function createMahasiswaProfile(User $user, Request $request, $pasFotoPath)
    {
        $mahasiswaData = [
            'user_id' => $user->id,
            'nama_lengkap' => $request->nama_lengkap_mhs,
            'nim' => $request->nim,
            'email' => $request->email,
            'status_mahasiswa' => $request->status_mahasiswa ?? 'Aktif',
            'status_sync' => $request->status_sync ?? 'Belum Sync',
            'prodi_id' => $request->prodi_id, // Gunakan prodi_id
        ];

        // Add optional fields only if they exist
        if ($request->filled('nik')) {
            $mahasiswaData['nik'] = $request->nik;
        }
        if ($request->filled('program_studi_mhs')) {
            $mahasiswaData['program_studi'] = $request->program_studi_mhs;
        }
        if ($request->filled('semester')) {
            $mahasiswaData['semester'] = (string) $request->semester;
        }
        if ($request->filled('jenis_kelamin_mhs')) {
            $mahasiswaData['jenis_kelamin'] = $request->jenis_kelamin_mhs;
        }
        if ($request->filled('tempat_lahir_mhs')) {
            $mahasiswaData['tempat_lahir'] = $request->tempat_lahir_mhs;
        }
        if ($request->filled('tanggal_lahir_mhs')) {
            $mahasiswaData['tanggal_lahir'] = $request->tanggal_lahir_mhs;
        }
        if ($request->filled('tanggal_masuk')) {
            $mahasiswaData['tanggal_masuk'] = $request->tanggal_masuk;
        }
        if ($request->filled('agama_mhs')) {
            $mahasiswaData['agama'] = $request->agama_mhs;
        }
        if ($request->filled('alamat_mhs')) {
            $mahasiswaData['alamat'] = $request->alamat_mhs;
        }
        if ($request->filled('no_telp_mhs')) {
            $mahasiswaData['no_telp'] = $request->no_telp_mhs;
        }
        if ($request->filled('biaya_masuk')) {
            $mahasiswaData['biaya_masuk'] = round($request->biaya_masuk, 2);
        }
        if ($pasFotoPath) {
            $mahasiswaData['pas_foto'] = $pasFotoPath;
        }

        $mahasiswa = Mahasiswa::create($mahasiswaData);
        \Log::info('Mahasiswa profile created:', ['id' => $mahasiswa->id]);
        
        return $mahasiswa;
    }

    private function createDosenProfile(User $user, Request $request, $pasFotoPath)
    {
        $dosenData = [
            'user_id' => $user->id,
            'nama_lengkap' => $request->nama_lengkap_dosen,
            'nidn' => $request->nidn,
            'email' => $request->email,
        ];

        // Add optional fields only if they exist
        if ($request->filled('program_studi')) {
            $dosenData['program_studi'] = $request->program_studi;
        }
        if ($request->filled('jenis_kelamin')) {
            $dosenData['jenis_kelamin'] = $request->jenis_kelamin;
        }
        if ($request->filled('tempat_lahir')) {
            $dosenData['tempat_lahir'] = $request->tempat_lahir;
        }
        if ($request->filled('tanggal_lahir')) {
            $dosenData['tanggal_lahir'] = $request->tanggal_lahir;
        }
        if ($request->filled('agama')) {
            $dosenData['agama'] = $request->agama;
        }
        if ($request->filled('alamat')) {
            $dosenData['alamat'] = $request->alamat;
        }
        if ($request->filled('no_telp')) {
            $dosenData['no_telp'] = $request->no_telp;
        }
        if ($pasFotoPath) {
            $dosenData['pas_foto'] = $pasFotoPath;
        }

        $dosen = DosenProfile::create($dosenData);
        \Log::info('Dosen profile created:', ['id' => $dosen->id]);
        
        return $dosen;
    }

    /**
     * Import Mahasiswa from Excel
     */
    public function importMahasiswa(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:5120', // Max 5MB
        ]);

        try {
            $file = $request->file('file');
            $import = new MahasiswaImport();
            
            Excel::import($import, $file);

            $errors = $import->getErrors();
            
            if (count($errors) > 0) {
                return redirect()->back()
                    ->with('warning', 'Import selesai dengan beberapa error. Silakan periksa data yang gagal.')
                    ->with('import_errors', $errors);
            }

            return redirect()->route('admin.manajemen-user.index')
                ->with('success', 'Data mahasiswa berhasil diimport!');

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errorMessages = [];
            
            foreach ($failures as $failure) {
                $errorMessages[] = "Baris {$failure->row()}: " . implode(', ', $failure->errors());
            }
            
            return redirect()->back()
                ->with('error', 'Validasi gagal!')
                ->with('validation_errors', $errorMessages);
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Import Dosen from Excel
     */
    public function importDosen(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:5120', // Max 5MB
        ]);

        try {
            $file = $request->file('file');
            $import = new DosenImport();
            
            Excel::import($import, $file);

            $errors = $import->getErrors();
            
            if (count($errors) > 0) {
                return redirect()->back()
                    ->with('warning', 'Import selesai dengan beberapa error. Silakan periksa data yang gagal.')
                    ->with('import_errors', $errors);
            }

            return redirect()->route('admin.manajemen-user.index')
                ->with('success', 'Data dosen berhasil diimport!');

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errorMessages = [];
            
            foreach ($failures as $failure) {
                $errorMessages[] = "Baris {$failure->row()}: " . implode(', ', $failure->errors());
            }
            
            return redirect()->back()
                ->with('error', 'Validasi gagal!')
                ->with('validation_errors', $errorMessages);
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Export data user dosen dan mahasiswa ke Excel
     */
    public function exportDosenMahasiswa(Request $request)
    {
        try {
            $role = $request->get('role', null);
            
            // Validasi role
            if ($role && !in_array($role, ['dosen', 'mahasiswa'])) {
                return redirect()->back()->with('error', 'Role tidak valid!');
            }

            $fileName = 'data_user_';
            if ($role === 'dosen') {
                $fileName .= 'dosen_';
            } elseif ($role === 'mahasiswa') {
                $fileName .= 'mahasiswa_';
            } else {
                $fileName .= 'dosen_mahasiswa_';
            }
            $fileName .= date('Ymd_His') . '.xlsx';

            return Excel::download(new DosenMahasiswaExport($role), $fileName);

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mengekspor data: ' . $e->getMessage());
        }
    }

    /**
     * Download template Excel for Mahasiswa
     */
    public function downloadTemplateMahasiswa()
    {
        $filePath = public_path('templates/template_mahasiswa.xlsx');
        
        if (file_exists($filePath)) {
            return response()->download($filePath);
        }
        
        return redirect()->back()->with('error', 'Template tidak ditemukan!');
    }

    /**
     * Download template Excel for Dosen
     */
    public function downloadTemplateDosen()
    {
        $filePath = public_path('templates/template_dosen.xlsx');
        
        if (file_exists($filePath)) {
            return response()->download($filePath);
        }
        
        return redirect()->back()->with('error', 'Template tidak ditemukan!');
    }
}