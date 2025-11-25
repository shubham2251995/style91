<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Style91 Installation Wizard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-indigo-50 to-blue-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-3xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-gray-800 mb-2">Style91 Installation</h1>
                <p class="text-gray-600">Follow the steps below to install your application</p>
            </div>

            <!-- Progress Bar -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <div class="flex justify-between mb-2">
                    <span class="text-sm font-medium" id="stepLabel">Step 1 of 6</span>
                    <span class="text-sm font-medium" id="stepProgress">0%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div id="progressBar" class="bg-indigo-600 h-3 rounded-full transition-all duration-500" style="width: 0%"></div>
                </div>
            </div>

            <!-- Main Card -->
            <div class="bg-white rounded-lg shadow-xl p-8">
                <!-- Step 1: Requirements -->
                <div id="step1" class="step-content">
                    <h2 class="text-2xl font-bold mb-4">System Requirements</h2>
                    <p class="text-gray-600 mb-6">Checking if your server meets the requirements...</p>
                    <div id="requirementsList" class="space-y-2 mb-6"></div>
                    <button onclick="checkRequirements()" class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700">
                        Check Requirements
                    </button>
                </div>

                <!-- Step 2: Database Config -->
                <div id="step2" class="step-content hidden">
                    <h2 class="text-2xl font-bold mb-4">Database Configuration</h2>
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium mb-1">Host</label>
                                <input type="text" id="db_host" value="127.0.0.1" class="w-full border rounded px-3 py-2">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1">Port</label>
                                <input type="text" id="db_port" value="3306" class="w-full border rounded px-3 py-2">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Database Name</label>
                            <input type="text" id="db_database" value="style91" class="w-full border rounded px-3 py-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Username</label>
                            <input type="text" id="db_username" value="root" class="w-full border rounded px-3 py-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Password</label>
                            <input type="password" id="db_password" class="w-full border rounded px-3 py-2">
                        </div>
                    </div>
                    <button onclick="testDatabase()" class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700 mt-6">
                        Test Connection
                    </button>
                </div>

                <!-- Step 3: Clean Database -->
                <div id="step3" class="step-content hidden">
                    <h2 class="text-2xl font-bold mb-4">Database Cleanup</h2>
                    <div id="cleanupInfo" class="mb-6"></div>
                    <button onclick="cleanDatabase()" class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700">
                        Clean Database
                    </button>
                </div>

                <!-- Step 4: App Config -->
                <div id="step4" class="step-content hidden">
                    <h2 class="text-2xl font-bold mb-4">Application Settings</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">App Name</label>
                            <input type="text" id="app_name" value="Style91" class="w-full border rounded px-3 py-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">App URL</label>
                            <input type="url" id="app_url" value="<?php echo url('/'); ?>" class="w-full border rounded px-3 py-2">
                        </div>
                    </div>
                    <button onclick="runMigrations()" class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700 mt-6">
                        Install Database
                    </button>
                </div>

                <!-- Step 5: Admin Account -->
                <div id="step5" class="step-content hidden">
                    <h2 class="text-2xl font-bold mb-4">Create Admin Account</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Name</label>
                            <input type="text" id="admin_name" value="Admin" class="w-full border rounded px-3 py-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Email</label>
                            <input type="email" id="admin_email" value="admin@style91.com" class="w-full border rounded px-3 py-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Mobile (Optional)</label>
                            <input type="text" id="admin_mobile" class="w-full border rounded px-3 py-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Password</label>
                            <input type="password" id="admin_password" class="w-full border rounded px-3 py-2" minlength="8">
                        </div>
                    </div>
                    <button onclick="createAdmin()" class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700 mt-6">
                        Create Admin & Finish
                    </button>
                </div>

                <!-- Step 6: Complete -->
                <div id="step6" class="step-content hidden text-center">
                    <div class="mb-6">
                        <svg class="w-24 h-24 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">Installation Complete!</h2>
                    <p class="text-gray-600 mb-6">Your Style91 application has been successfully installed.</p>
                    <a href="/" class="inline-block bg-indigo-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-indigo-700">
                        Go to Homepage
                    </a>
                </div>

                <!-- Status Messages -->
                <div id="statusMessage" class="mt-6 hidden"></div>
            </div>
        </div>
    </div>

    <script>
        let currentStep = 1;
        let dbConfig = {};

        function updateProgress(step) {
            currentStep = step;
            const progress = (step / 6) * 100;
            document.getElementById('progressBar').style.width = progress + '%';
            document.getElementById('stepLabel').textContent = `Step ${step} of 6`;
            document.getElementById('stepProgress').textContent = Math.round(progress) + '%';
        }

        function showStep(step) {
            document.querySelectorAll('.step-content').forEach(el => el.classList.add('hidden'));
            document.getElementById('step' + step).classList.remove('hidden');
            updateProgress(step);
        }

        function showMessage(message, type = 'info') {
            const statusEl = document.getElementById('statusMessage');
            const colors = {
                success: 'bg-green-100 text-green-800 border-green-200',
                error: 'bg-red-100 text-red-800 border-red-200',
                info: 'bg-blue-100 text-blue-800 border-blue-200',
                warning: 'bg-yellow-100 text-yellow-800 border-yellow-200'
            };
            statusEl.className = `mt-6 p-4 rounded border ${colors[type]}`;
            statusEl.textContent = message;
            statusEl.classList.remove('hidden');
        }

        async function checkRequirements() {
            try {
                const response = await fetch('/install/check-requirements');
                const data = await response.json();
                
                const list = document.getElementById('requirementsList');
                list.innerHTML = '';
                
                for (const [key, value] of Object.entries(data.requirements)) {
                    const item = document.createElement('div');
                    item.className = `flex items-center justify-between p-3 rounded ${value ? 'bg-green-50' : 'bg-red-50'}`;
                    item.innerHTML = `
                        <span class="font-medium">${key.replace(/_/g, ' ').toUpperCase()}</span>
                        <span class="${value ? 'text-green-600' : 'text-red-600'}">${value ? '✓' : '✗'}</span>
                    `;
                    list.appendChild(item);
                }
                
                if (data.success) {
                    showMessage('All requirements met!', 'success');
                    setTimeout(() => showStep(2), 1500);
                } else {
                    showMessage('Some requirements not met. Please fix them before continuing.', 'error');
                }
            } catch (error) {
                showMessage('Error checking requirements: ' + error.message, 'error');
            }
        }

        async function testDatabase() {
            dbConfig = {
                db_host: document.getElementById('db_host').value,
                db_port: document.getElementById('db_port').value,
                db_database: document.getElementById('db_database').value,
                db_username: document.getElementById('db_username').value,
                db_password: document.getElementById('db_password').value,
            };

            try {
                const response = await fetch('/install/test-database', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': '<?php echo csrf_token(); ?>'},
                    body: JSON.stringify(dbConfig)
                });
                
                const data = await response.json();
                
                if (data.success) {
                    if (data.tables_exist) {
                        document.getElementById('cleanupInfo').innerHTML = `
                            <div class="bg-yellow-50 border border-yellow-200 rounded p-4">
                                <p class="font-medium text-yellow-800">⚠️ Database contains ${data.table_count} tables</p>
                                <p class="text-sm text-yellow-700 mt-2">All existing tables will be dropped to ensure a clean installation.</p>
                            </div>
                        `;
                    } else {
                        document.getElementById('cleanupInfo').innerHTML = `
                            <div class="bg-green-50 border border-green-200 rounded p-4">
                                <p class="font-medium text-green-800">✓ Database is empty and ready</p>
                            </div>
                        `;
                    }
                    showMessage('Database connection successful!', 'success');
                    setTimeout(() => showStep(3), 1500);
                } else {
                    showMessage(data.message, 'error');
                }
            } catch (error) {
                showMessage('Connection failed: ' + error.message, 'error');
            }
        }

        async function cleanDatabase() {
            try {
                const response = await fetch('/install/clean-database', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': '<?php echo csrf_token(); ?>'},
                    body: JSON.stringify(dbConfig)
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showMessage(`Database cleaned! Dropped ${data.count} tables.`, 'success');
                    setTimeout(() => showStep(4), 1500);
                } else {
                    showMessage(data.message, 'error');
                }
            } catch (error) {
                showMessage('Cleanup failed: ' + error.message, 'error');
            }
        }

        async function runMigrations() {
            const appConfig = {
                ...dbConfig,
                app_name: document.getElementById('app_name').value,
                app_url: document.getElementById('app_url').value,
            };

            try {
                showMessage('Installing database... This may take a minute.', 'info');
                
                const response = await fetch('/install/run-migrations', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': '<?php echo csrf_token(); ?>'},
                    body: JSON.stringify(appConfig)
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Try to seed
                    await fetch('/install/seed-database', {
                        method: 'POST',
                        headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': '<?php echo csrf_token(); ?>'}
                    });
                    
                    showMessage('Database installed successfully!', 'success');
                    setTimeout(() => showStep(5), 1500);
                } else {
                    showMessage(data.message, 'error');
                }
            } catch (error) {
                showMessage('Migration failed: ' + error.message, 'error');
            }
        }

        async function createAdmin() {
            const adminConfig = {
                admin_name: document.getElementById('admin_name').value,
                admin_email: document.getElementById('admin_email').value,
                admin_mobile: document.getElementById('admin_mobile').value,
                admin_password: document.getElementById('admin_password').value,
            };

            try {
                const response = await fetch('/install/create-admin', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': '<?php echo csrf_token(); ?>'},
                    body: JSON.stringify(adminConfig)
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showStep(6);
                } else {
                    showMessage(data.message, 'error');
                }
            } catch (error) {
                showMessage('Failed to create admin: ' + error.message, 'error');
            }
        }
    </script>
</body>
</html>
