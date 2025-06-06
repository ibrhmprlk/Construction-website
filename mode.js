document.addEventListener('DOMContentLoaded', () => {
    const toggleBtn = document.getElementById('theme-toggle');
    if (!toggleBtn) return;
  
    const icon = toggleBtn.querySelector('i');
  
    // LocalStorage'dan tema durumunu al, yoksa 'light-mode' ile başla
    const savedMode = localStorage.getItem('mode') || 'light-mode';
    document.body.classList.add(savedMode);
  
    // Buton ikonunu tema durumuna göre ayarla
    if (savedMode === 'dark-mode') {
      icon.classList.remove('fa-sun');
      icon.classList.add('fa-moon');
    } else {
      icon.classList.remove('fa-moon');
      icon.classList.add('fa-sun');
    }
  
    toggleBtn.addEventListener('click', () => {
      if (document.body.classList.contains('light-mode')) {
        document.body.classList.replace('light-mode', 'dark-mode');
        localStorage.setItem('mode', 'dark-mode');
  
        icon.classList.remove('fa-sun');
        icon.classList.add('fa-moon');
      } else {
        document.body.classList.replace('dark-mode', 'light-mode');
        localStorage.setItem('mode', 'light-mode');
  
        icon.classList.remove('fa-moon');
        icon.classList.add('fa-sun');
      }
    });
  });
  