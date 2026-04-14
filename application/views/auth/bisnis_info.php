<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Informasi Bisnis Anda - USAHAIN</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    html, body {
      height: 100%;
      width: 100%;
    }
    
    body {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      padding: 20px;
    }
    
    .container-wrapper {
      width: 100%;
      max-width: 500px;
    }
    
    .card-bisnis {
      background: #ffffff;
      border-radius: 20px;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
      overflow: hidden;
      animation: slideIn 0.3s ease-out;
    }
    
    @keyframes slideIn {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    
    .card-header-bisnis {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      padding: 32px 28px;
      position: relative;
    }
    
    .card-header-bisnis h1 {
      font-size: 28px;
      font-weight: 700;
      margin: 0;
      display: flex;
      align-items: center;
      gap: 12px;
    }
    
    .card-header-bisnis .subtitle {
      font-size: 14px;
      opacity: 0.9;
      margin-top: 8px;
      font-weight: 400;
    }
    
    .btn-close-custom {
      position: absolute;
      top: 20px;
      right: 20px;
      background: rgba(255, 255, 255, 0.2);
      border: none;
      color: white;
      width: 40px;
      height: 40px;
      border-radius: 50%;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: 0.2s;
    }
    
    .btn-close-custom:hover {
      background: rgba(255, 255, 255, 0.3);
      transform: scale(1.05);
    }
    
    .card-body-bisnis {
      padding: 32px 28px;
    }
    
    .progress-section {
      margin-bottom: 28px;
    }
    
    .progress-text {
      font-size: 12px;
      color: #667eea;
      font-weight: 600;
      margin-bottom: 6px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    
    .progress {
      height: 6px;
      background: #e0e0e0;
      border-radius: 3px;
      overflow: hidden;
    }
    
    .progress-bar {
      background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
      height: 100%;
    }
    
    .info-card {
      background: linear-gradient(135deg, #e8eaf6 0%, #f3e5f5 100%);
      border-radius: 12px;
      padding: 16px;
      margin-bottom: 24px;
      display: flex;
      align-items: flex-start;
      gap: 12px;
      border-left: 4px solid #667eea;
    }
    
    .info-card .icon {
      font-size: 20px;
      flex-shrink: 0;
      margin-top: 2px;
    }
    
    .info-card-content h3 {
      font-size: 15px;
      font-weight: 700;
      color: #2d1b4e;
      margin-bottom: 4px;
    }
    
    .info-card-content p {
      font-size: 14px;
      color: #5e35b1;
      margin: 0;
      line-height: 1.4;
    }
    
    .form-group {
      margin-bottom: 20px;
    }
    
    .form-label {
      font-weight: 600;
      color: #222222;
      font-size: 15px;
      margin-bottom: 8px;
      display: block;
    }
    
    .form-label .optional {
      color: #999;
      font-weight: 400;
      font-size: 13px;
      margin-left: 4px;
    }
    
    .form-control {
      background: #f8f9fa;
      border: 2px solid #e0e0e0;
      border-radius: 10px;
      padding: 12px 14px;
      font-size: 15px;
      transition: 0.3s;
      font-family: inherit;
    }
    
    .form-control:focus {
      border-color: #667eea;
      background: #ffffff;
      box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
      outline: none;
    }
    
    .form-control::placeholder {
      color: #bdbdbd;
      font-size: 14px;
    }
    
    .form-control.error {
      border-color: #d32f2f;
      background: #ffebee;
    }
    
    .error-message {
      color: #d32f2f;
      font-size: 13px;
      margin-top: 4px;
      display: none;
    }
    
    .error-message.show {
      display: block;
    }
    
    .note-box {
      background: #fff8e1;
      border: 1px solid #ffe082;
      border-radius: 10px;
      padding: 12px 14px;
      margin-bottom: 24px;
      display: flex;
      gap: 10px;
      align-items: flex-start;
      color: #b26a00;
      font-size: 14px;
    }
    
    .note-box .icon {
      font-size: 16px;
      flex-shrink: 0;
      margin-top: 2px;
    }
    
    .button-group {
      display: flex;
      gap: 12px;
      justify-content: space-between;
    }
    
    .btn {
      border-radius: 10px;
      font-weight: 600;
      padding: 12px 24px;
      font-size: 15px;
      border: none;
      cursor: pointer;
      transition: 0.3s;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      min-width: 120px;
    }
    
    .btn-primary-custom {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      box-shadow: 0 8px 24px rgba(102, 126, 234, 0.4);
    }
    
    .btn-primary-custom:hover {
      transform: translateY(-2px);
      box-shadow: 0 12px 32px rgba(102, 126, 234, 0.5);
      color: white;
    }
    
    .btn-primary-custom:active {
      transform: translateY(0);
    }
    
    .btn-primary-custom:disabled {
      opacity: 0.6;
      cursor: not-allowed;
      transform: none;
    }
    
    .btn-secondary-custom {
      background: white;
      color: #667eea;
      border: 2px solid #e0e0e0;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    }
    
    .btn-secondary-custom:hover {
      border-color: #667eea;
      color: #667eea;
      background: #f8f9fa;
      transform: translateY(-2px);
    }
    
    .btn-secondary-custom:active {
      transform: translateY(0);
    }
    
    .loading-spinner {
      display: none;
      width: 16px;
      height: 16px;
      border: 2px solid rgba(255, 255, 255, 0.3);
      border-top-color: white;
      border-radius: 50%;
      animation: spin 0.6s linear infinite;
    }
    
    @keyframes spin {
      to { transform: rotate(360deg); }
    }
    
    .btn-primary-custom .loading-spinner {
      display: none;
    }
    
    .btn-primary-custom.loading .loading-spinner {
      display: block;
    }
    
    .btn-primary-custom.loading .btn-text {
      display: none;
    }
    
    .success-message {
      display: none;
      background: #e8f5e9;
      color: #2e7d32;
      padding: 14px;
      border-radius: 10px;
      margin-bottom: 16px;
      border-left: 4px solid #4caf50;
    }
    
    .success-message.show {
      display: flex;
      align-items: center;
      gap: 10px;
      animation: slideIn 0.3s ease-out;
    }
    
    @media (max-width: 600px) {
      body {
        padding: 12px;
      }
      
      .container-wrapper {
        max-width: 100%;
      }
      
      .card-header-bisnis {
        padding: 24px 20px;
      }
      
      .card-header-bisnis h1 {
        font-size: 24px;
      }
      
      .card-body-bisnis {
        padding: 24px 20px;
      }
      
      .button-group {
        flex-direction: column-reverse;
      }
      
      .btn {
        width: 100%;
        min-width: unset;
      }
    }
  </style>
</head>
<body>
  <div class="container-wrapper">
    <div class="card-bisnis">
      <div class="card-header-bisnis">
        <button type="button" class="btn-close-custom" onclick="window.location.href='<?= site_url('auth/dashboard'); ?>'">
          <i class="fas fa-times"></i>
        </button>
        <h1>
          <i class="fas fa-briefcase"></i>
          Informasi Bisnis
        </h1>
        <p class="subtitle">Lengkapi data bisnis Anda untuk memulai</p>
      </div>
      
      <div class="card-body-bisnis">
        <!-- Progress -->
        <div class="progress-section">
          <div class="progress-text">Langkah 1 dari 3</div>
          <div class="progress">
            <div class="progress-bar" style="width: 33.33%"></div>
          </div>
        </div>
        
        <!-- Info Card -->
        <div class="info-card">
          <div class="icon">📋</div>
          <div class="info-card-content">
            <h3>Calon Pemilik UMKM</h3>
            <p>Mulai dengan persiapan dan pengelolaan bisnis Anda secara profesional</p>
          </div>
        </div>
        
        <!-- Success Message -->
        <div class="success-message" id="successMessage">
          <i class="fas fa-check-circle"></i>
          <span id="successText">Informasi bisnis berhasil disimpan!</span>
        </div>
        
        <!-- Form -->
        <form id="formInformasiBisnis">
          <!-- Nama Usaha Section -->
          <div class="form-group">
            <label class="form-label">
              <i class="fas fa-store" style="color: #667eea; margin-right: 8px;"></i>
              Nama Usaha
              <span class="optional">(Opsional)</span>
            </label>
            <input 
              type="text" 
              name="nama_usaha" 
              id="nama_usaha" 
              class="form-control" 
              placeholder="Contoh: Warung Makan Berkah"
              maxlength="100"
            >
            <div class="error-message" id="error_nama_usaha"></div>
          </div>
          
          <!-- Jenis Usaha Section -->
          <div class="form-group">
            <label class="form-label">
              <i class="fas fa-briefcase" style="color: #667eea; margin-right: 8px;"></i>
              Jenis Usaha
              <span class="optional">(Opsional)</span>
            </label>
            <input 
              type="text" 
              name="jenis_usaha" 
              id="jenis_usaha" 
              class="form-control" 
              placeholder="Contoh: Kuliner, Fashion, Jasa, Retail, dll"
              maxlength="100"
            >
            <div class="error-message" id="error_jenis_usaha"></div>
          </div>
          
          <!-- Note -->
          <div class="note-box">
            <div class="icon">💡</div>
            <div>Anda dapat mengubah informasi ini kapan saja di pengaturan profil</div>
          </div>
          
          <!-- Buttons -->
          <div class="button-group">
            <button 
              type="button" 
              class="btn btn-secondary-custom"
              onclick="window.location.href='<?= site_url('auth/dashboard'); ?>'"
            >
              <i class="fas fa-times"></i>
              Lewati
            </button>
            <button 
              type="submit" 
              class="btn btn-primary-custom" 
              id="submitBtn"
            >
              <span class="btn-text">
                <i class="fas fa-arrow-right"></i>
                Lanjutkan
              </span>
              <div class="loading-spinner"></div>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    const form = document.getElementById('formInformasiBisnis');
    const submitBtn = document.getElementById('submitBtn');
    const successMessage = document.getElementById('successMessage');
    
    // Validasi input
    function validateForm() {
      let isValid = true;
      
      // Clear previous errors
      document.querySelectorAll('.error-message').forEach(el => {
        el.classList.remove('show');
      });
      document.querySelectorAll('.form-control').forEach(el => {
        el.classList.remove('error');
      });
      
      const namaUsaha = document.getElementById('nama_usaha').value.trim();
      const jenisUsaha = document.getElementById('jenis_usaha').value.trim();
      
      // Validasi panjang minimal jika ada input
      if (namaUsaha && namaUsaha.length < 3) {
        showError('error_nama_usaha', 'Nama usaha minimal 3 karakter');
        isValid = false;
      }
      
      if (jenisUsaha && jenisUsaha.length < 3) {
        showError('error_jenis_usaha', 'Jenis usaha minimal 3 karakter');
        isValid = false;
      }
      
      return isValid;
    }
    
    function showError(elementId, message) {
      const errorEl = document.getElementById(elementId);
      const fieldName = elementId.replace('error_', '');
      const fieldEl = document.getElementById(fieldName);
      
      errorEl.textContent = message;
      errorEl.classList.add('show');
      fieldEl.classList.add('error');
    }
    
    // Form submit handler
    form.addEventListener('submit', async function(e) {
      e.preventDefault();
      
      if (!validateForm()) {
        return;
      }
      
      const namaUsaha = document.getElementById('nama_usaha').value.trim();
      const jenisUsaha = document.getElementById('jenis_usaha').value.trim();
      
      // Set loading state
      submitBtn.disabled = true;
      submitBtn.classList.add('loading');
      
      try {
        const response = await fetch('<?= site_url('user/save_bisnis_info'); ?>', {
          method: 'POST',
          headers: { 
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
          },
          body: JSON.stringify({
            nama_usaha: namaUsaha,
            jenis_usaha: jenisUsaha
          })
        });
        
        if (!response.ok) {
          throw new Error('Network error: ' + response.statusText);
        }
        
        const data = await response.json();
        
        if (data.status === 'success' || data.success === true) {
          // Show success message
          document.getElementById('successText').textContent = 
            data.message || 'Informasi bisnis berhasil disimpan!';
          successMessage.classList.add('show');
          
          // Redirect setelah 1.5 detik
          setTimeout(() => {
            window.location.href = '<?= site_url('auth/dashboard'); ?>';
          }, 1500);
        } else {
          // Handle error response from server
          showError('error_nama_usaha', data.message || 'Gagal menyimpan data. Silakan coba lagi.');
          submitBtn.disabled = false;
          submitBtn.classList.remove('loading');
        }
      } catch (error) {
        console.error('Error:', error);
        
        // Show detailed error message
        let errorMessage = 'Gagal menyimpan data. Server response tidak valid JSON. Check console (F12).';
        if (error.message) {
          errorMessage = error.message;
        }
        
        showError('error_nama_usaha', errorMessage);
        submitBtn.disabled = false;
        submitBtn.classList.remove('loading');
      }
    });
    
    // Real-time validation on input
    document.getElementById('nama_usaha').addEventListener('blur', function() {
      if (this.value.trim() && this.value.trim().length < 3) {
        showError('error_nama_usaha', 'Nama usaha minimal 3 karakter');
      } else {
        this.classList.remove('error');
        document.getElementById('error_nama_usaha').classList.remove('show');
      }
    });
    
    document.getElementById('jenis_usaha').addEventListener('blur', function() {
      if (this.value.trim() && this.value.trim().length < 3) {
        showError('error_jenis_usaha', 'Jenis usaha minimal 3 karakter');
      } else {
        this.classList.remove('error');
        document.getElementById('error_jenis_usaha').classList.remove('show');
      }
    });
  </script>
</body>
</html>
