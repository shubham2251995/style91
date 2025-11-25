<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Style91 Installer</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-lg p-8 max-w-2xl w-full">
            <h1 class="text-3xl font-bold mb-6 text-center">Style91 Installation</h1>
            
            <form id="installForm" class="space-y-6">
                <div class="border-b pb-4">
                    <h2 class="text-xl font-semibold mb-4">Application Settings</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">App Name</label>
                            <input type="text" name="app_name" value="Style91" class="w-full border rounded px-3 py-2" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">App URL</label>
                            <input type="url" name="app_url" value="<?php echo url('/'); ?>" class="w-full border rounded px-3 py-2" required>
                        </div>
                    </div>
                </div>

                <div class="border-b pb-4">
                    <h2 class="text-xl font-semibold mb-4">Database Settings</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Host</label>
                            <input type="text" name="db_host" value="127.0.0.1" class="w-full border rounded px-3 py-2" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Port</label>
                            <input type="text" name="db_port" value="3306" class="w-full border rounded px-3 py-2" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Database Name</label>
                            <input type="text" name="db_database" value="style91" class="w-full border rounded px-3 py-2" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Username</label>
                            <input type="text" name="db_username" value="root" class="w-full border rounded px-3 py-2" required>
                        </div>
                        <div class="col-span-2">
                            <label class="block text-sm font-medium mb-1">Password</label>
                            <input type="password" name="db_password" class="w-full border rounded px-3 py-2">
                        </div>
                    </div>
                </div>

                <div class="border-b pb-4">
                    <h2 class="text-xl font-semibold mb-4">Admin Account</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Name</label>
                            <input type="text" name="admin_name" value="Admin" class="w-full border rounded px-3 py-2" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Email</label>
                            <input type="email" name="admin_email" value="admin@style91.com" class="w-full border rounded px-3 py-2" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Mobile</label>
                            <input type="text" name="admin_mobile" class="w-full border rounded px-3 py-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Password</label>
                            <input type="password" name="admin_password" class="w-full border rounded px-3 py-2" required minlength="8">
                        </div>
                    </div>
                </div>

                <button type="submit" id="installBtn" class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700">
                    Install Now
                </button>

                <div id="status" class="hidden mt-4 p-4 rounded"></div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('installForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const btn = document.getElementById('installBtn');
            const status = document.getElementById('status');
            
            btn.disabled = true;
            btn.textContent = 'Installing...';
            status.className = 'mt-4 p-4 rounded bg-blue-100 text-blue-800';
            status.textContent = 'Installing... This may take a few minutes.';
            status.classList.remove('hidden');
            
            const formData = new FormData(this);
            const data = Object.fromEntries(formData);
            
            try {
                const response = await fetch('/install-process', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '<?php echo csrf_token(); ?>'
                    },
                    body: JSON.stringify(data)
                });
                
                const result = await response.json();
                
                if (result.success) {
                    status.className = 'mt-4 p-4 rounded bg-green-100 text-green-800';
                    status.textContent = 'Installation complete! Redirecting...';
                    setTimeout(() => window.location.href = '/', 2000);
                } else {
                    status.className = 'mt-4 p-4 rounded bg-red-100 text-red-800';
                    status.textContent = 'Error: ' + result.message;
                    btn.disabled = false;
                    btn.textContent = 'Install Now';
                }
            } catch (error) {
                status.className = 'mt-4 p-4 rounded bg-red-100 text-red-800';
                status.textContent = 'Error: ' + error.message;
                btn.disabled = false;
                btn.textContent = 'Install Now';
            }
        });
    </script>
</body>
</html>
