<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Task Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800 p-8">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-4 text-blue-600">KEPL Task Manager (CRUD)</h1>
        
        <form id="taskForm" class="mb-6 space-y-3">
            <div>
                <input type="text" id="title" placeholder="Judul Tugas..." required
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <input type="text" id="description" placeholder="Deskripsi (opsional)..."
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg">
                Tambah Tugas
            </button>
        </form>

        <h2 class="text-lg font-semibold mb-2">Daftar Tugas</h2>
        <div id="taskList" class="space-y-2">
            <p class="text-gray-400 text-sm">Memuat data...</p>
        </div>
    </div>

    <script>
        async function fetchTasks() {
            const res = await fetch('/api/tasks');
            const tasks = await res.json();
            const list = document.getElementById('taskList');
            
            if (tasks.length === 0) {
                list.innerHTML = '<p class="text-gray-400 text-sm italic">Belum ada tugas. Tambah lewat form di atas!</p>';
                return;
            }

            list.innerHTML = tasks.map(task => `
                <div class="flex items-center justify-between p-3 border rounded-lg ${task.is_completed ? 'bg-green-50 border-green-200' : 'bg-gray-50'}">
                    <div>
                        <h3 class="font-medium ${task.is_completed ? 'line-through text-gray-400' : ''}">${task.title}</h3>
                        ${task.description ? `<p class="text-sm text-gray-500">${task.description}</p>` : ''}
                    </div>
                    <div class="flex gap-2">
                        <button onclick="toggleTask(${task.id}, ${!task.is_completed})" class="px-2 py-1 text-xs rounded ${task.is_completed ? 'bg-yellow-500 text-white' : 'bg-green-600 text-white'}">
                            ${task.is_completed ? 'Batal Selesai' : 'Selesai'}
                        </button>
                        <button onclick="deleteTask(${task.id})" class="px-2 py-1 text-xs bg-red-600 text-white rounded">
                            Hapus
                        </button>
                    </div>
                </div>
            `).join('');
        }

        document.getElementById('taskForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const title = document.getElementById('title').value;
            const description = document.getElementById('description').value;

            await fetch('/api/tasks', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                body: JSON.stringify({ title, description, is_completed: false })
            });

            document.getElementById('title').value = '';
            document.getElementById('description').value = '';
            fetchTasks();
        });

        async function toggleTask(id, is_completed) {
            await fetch(`/api/tasks/${id}`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                body: JSON.stringify({ is_completed })
            });
            fetchTasks();
        }

        async function deleteTask(id) {
            await fetch(`/api/tasks/${id}`, {
                method: 'DELETE',
                headers: { 'Accept': 'application/json' }
            });
            fetchTasks();
        }

        fetchTasks();
    </script>
</body>
</html>
