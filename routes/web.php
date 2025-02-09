<?php  

use App\Http\Controllers\ProfileController;  
use Illuminate\Support\Facades\Route;  
use App\Http\Controllers\CekPlagiasiController;  
use App\Http\Controllers\AdminController;  
use App\Http\Controllers\DashboardController;  
use App\Http\Controllers\TokenController;  
use App\Http\Controllers\TransactionController;  
use App\Http\Controllers\PembayaranController;  
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\MidtransPembayaranController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Halaman Utama
Route::get('/', function () {  
    return view('welcome');  
});  

// Rute Autentikasi
require __DIR__.'/auth.php';  


// Route untuk menampilkan halaman metode pembayaran Midtrans
Route::get('/pembayaran/midtrans/payment-methods/{document_id}', [MidtransPembayaranController::class, 'showPaymentMethods'])->name('pembayaran.methods');


// Route untuk memproses pembayaran Midtrans
Route::post('/pembayaran/midtrans/checkout', [MidtransPembayaranController::class, 'process'])->name('checkout');

// Route untuk menangani callback Midtrans
Route::post('/pembayaran/midtrans/callback', [MidtransPembayaranController::class, 'callback'])->name('pembayaran.callback');

// Route untuk sukses pembayaran
Route::get('/pembayaran/midtrans/success/{trxId}', [MidtransPembayaranController::class, 'showSuccess'])->name('pembayaran.success');
Route::get('/cek-pembelian/results/{nomor_hp}', [PembayaranController::class, 'result'])->name('cek-pembelian.results');

// Route::post('/midtrans/callback', [MidtransPembayaranController::class, 'callback'])->name('midtrans.callback');
Route::post('/midtrans/callback', [CekPlagiasiController::class, 'callback'])->name('midtrans.callback');

// Route untuk pembatalan pembayaran
Route::get('/pembayaran/midtrans/cancel/{nomor_hp}', [MidtransPembayaranController::class, 'showCancel'])->name('pembayaran.cancel');
// Route untuk riwayat transaksi
Route::get('/transaksi/history', [MidtransPembayaranController::class, 'history'])->name('history');
// Rute Cek Turnitin (Tanpa Middleware)
Route::get('/cek-turnitin', [CekPlagiasiController::class, 'index'])->name('cek-turnitin.index');  
Route::post('/cek-turnitin', [CekPlagiasiController::class, 'store'])->name('cek-turnitin.store');  
Route::get('/cek-turnitin/details', [CekPlagiasiController::class, 'showDetails'])->name('cek-turnitin.details');  
Route::get('/cek-turnitin/notify/{trxId}', [CekPlagiasiController::class, 'notify'])->name('cek-turnitin.notify');  

// Rute Cek Pembelian (Tanpa Middleware)
Route::post('/cek-pembelian', [CekPlagiasiController::class, 'processPhoneNumber'])->name('cek-pembelian.process');  
Route::get('/cek-pembelian/result/{nomor_hp}', [CekPlagiasiController::class, 'showPurchases'])->name('cek-pembelian.showPurchases');  
Route::get('/cek-pembelian/results/{nomor_hp}', [CekPlagiasiController::class, 'showPurchases'])->name('cek-pembelian.results');  
Route::post('/daftar-profil', [CekPlagiasiController::class, 'storeProfil'])->name('daftar.profil');  

// Transaksi Routes (Tanpa Middleware)
Route::get('/transaksi/history', [TransaksiController::class, 'history'])->name('transaksi.history');
// Route notifikasi Midtrans
Route::post('/midtrans/notify/{trxId}', [CekPlagiasiController::class, 'notify'])->name('cek-turnitin.notify');
// Rute Pembayaran (Tanpa Middleware)
Route::get('/pembayaran/{id}', [PembayaranController::class, 'index'])->name('pembayaran.index');  
Route::post('/pembayaran/process', [PembayaranController::class, 'process'])->name('pembayaran.process');  
Route::match(['get', 'post'], '/pembayaran/notify/{trxId}', [PembayaranController::class, 'notify'])->name('pembayaran.notify');  
// Route::get('/pembayaran/success/{trxId}', [PembayaranController::class, 'success'])->name('pembayaran.success');  
Route::post('/pembayaran/create-va', [PembayaranController::class, 'createVA'])->name('pembayaran.createVa');  
Route::post('/pembayaran/virtual-account', [PembayaranController::class, 'virtualAccount'])->name('pembayaran.virtual_account');  
Route::post('/pembayaran/virtual-account/callback/{trxId}', [PembayaranController::class, 'virtualAccountCallback'])->name('pembayaran.virtual_account.callback');  
Route::get('/redirect-bayar', [PembayaranController::class, 'redirectToPaymentLink'])->name('redirect.bayar');  

// Grup Middleware untuk Rute yang Memerlukan Autentikasi dan Verifikasi
Route::middleware(['auth'])->group(function () { 
    // Dashboard 
   // Rute utama dashboard yang memeriksa peran
   Route::get('/user/dashboard', [DashboardController::class, 'user'])->name('user.dashboard');
   Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
   Route::post('user/dashboard/process', [DashboardController::class, 'process'])->name('dashboard.process');
   // Rute khusus untuk superadmin
  

   // Rute khusus untuk user biasa
   
    
    // Profile 
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');  
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');  
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');  

    // Superadmin Dashboard 
    Route::get('/dashboard/superadmin', [DashboardController::class, 'index'])->name('dashboard.superadmin');  
    Route::patch('/dashboard/superadmin/{id}', [DashboardController::class, 'update'])->name('dashboard.superadmin.update');  

    // Token Processing 
    Route::post('/token/process', [CekPlagiasiController::class, 'processToken'])->name('token.process');  

    // Document Viewing 
    Route::get('/documents/view/{id}', [CekPlagiasiController::class, 'viewDocument'])->name('documents.view');  

    // Status Update 
    Route::patch('/dashboard/status/{id}', [DashboardController::class, 'updateStatus'])->name('dashboard.updateStatus');  

    // Transaction Routes 
    Route::get('/cek-turnitin/{cek_plagiasi}/pay', [TransactionController::class, 'showPaymentForm'])->name('transactions.pay');  
    Route::post('/cek-turnitin/{cek_plagiasi}/pay', [TransactionController::class, 'processPayment'])->name('transactions.processPayment');  
    Route::get('/transactions/history', [TransactionController::class, 'history'])->name('transactions.history');  
    Route::get('/transactions/{transaction}/download', [TransactionController::class, 'downloadDocument'])->name('transactions.download');  
    
    // Dashboard Edit and Update 
    Route::get('/dashboard/edit/{id}', [DashboardController::class, 'edit'])->name('dashboard.edit'); 
    Route::patch('/dashboard/{id}/update-document-file', [DashboardController::class, 'updateDocumentFile'])->name('dashboard.updateDocumentFile'); 
    Route::patch('/dashboard/{dashboard}', [DashboardController::class, 'update'])->name('dashboard.update'); 
    Route::get('/dashboard/{id}/download', [DashboardController::class, 'download'])
        ->name('dashboard.download')
        ->middleware('auth'); 
});


Route::get('/pembayaran/methods/{document_id}', [PembayaranController::class, 'showPaymentMethods'])->name('pembayaran.methods');