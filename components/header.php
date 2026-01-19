<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Karbono Marketplace</title>
    <link rel="icon" type="image/x-icon" href="assets/images/karbono_logo.png">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Borel&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Nunito', 'sans-serif'], display: ['Borel', 'cursive'] },
                    colors: { karbono: { green: '#76B947', dark: '#2C3E50', orange: '#F39C12' } },
                    animation: { 'fade-in': 'fadeIn 0.3s ease-out forwards' },
                    keyframes: { fadeIn: { '0%': { opacity: '0', transform: 'scale(0.95)' }, '100%': { opacity: '1', transform: 'scale(1)' } } }
                }
            }
        }
    </script>
    <style>
        /* Custom Scrollbar for Cart */
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        
        /* Dialog Backdrop Fix */
        dialog::backdrop { background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); }
    </style>
</head>