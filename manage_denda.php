<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Fines</title>
<?php include 'includes/meta.php'; ?>
</head>

<body class="bg-gray-100 font-sans m-0 p-0 min-h-svh">
    <header class="bg-gray-800 text-white p-4 border-b-4 border-blue-500">
        <div class="container mx-auto flex justify-between items-center md:w-4/5">
            <div id="branding" class="text-lg font-bold">
                <h1><a href="#" class="text-white uppercase">Manage Fine</a></h1>
            </div>
            <nav class="hidden md:flex space-x-6">
                <a href="#" class="text-white uppercase">Home</a>
                <a href="#" class="text-white uppercase">About</a>
                <a href="#" class="text-white uppercase">Services</a>
                <a href="#" class="text-white uppercase">Contact</a>
            </nav>
            <div class="md:hidden">
                <button id="nav-toggle" class="text-white focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
            </div>
        </div>
        <div id="nav-menu" class="md:hidden hidden">
            <nav class="flex flex-col items-center space-y-4 mt-4">
                <a href="#" class="text-white uppercase">Home</a>
                <a href="#" class="text-white uppercase">About</a>
                <a href="#" class="text-white uppercase">Services</a>
                <a href="#" class="text-white uppercase">Contact</a>
            </nav>
        </div>
    </header>

    <div class="container mx-auto  md:p-4 md:w-4/5">
        <h1 class="text-2xl font-bold mb-4">Management Fine</h1>
        <button class="btn mb-4 bg-blue-500 text-white hover:bg-blue-700" onclick="my_modal_3.showModal()">add user</button>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300">
                <thead class="bg-black text-white">
                    <tr>
                        <th class="py-2 px-2 md:px-4 border border-gray-300">ID</th>
                        <th class="py-2 px-2 md:px-4 border border-gray-300">Total Denda</th>
                        <th class="py-2 px-2 md:px-4 border border-gray-300">Keterangan</th>
                        <th class="py-2 px-2 md:px-4 border border-gray-300">ID Admin</th>
                        <th class="py-2 px-2 md:px-4 border border-gray-300">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="hover:bg-gray-200">
                        <td class="py-2 px-2 md:px-4 border border-gray-300">1</td>
                        <td class="py-2 px-2 md:px-4 border border-gray-300">100,000</td>
                        <td class="py-2 px-2 md:px-4 border border-gray-300">Late Payment</td>
                        <td class="py-2 px-2 md:px-4 border border-gray-300">Admin01</td>
                        <td class="py-2 px-2 md:px-4 border border-gray-300">
                            <button class="bg-blue-500 text-white px-2 md:px-3 py-1 rounded hover:bg-blue-700">Edit</button>
                            <button class="bg-red-500 text-white px-2 md:px-3 py-1 rounded hover:bg-red-700">Delete</button>
                        </td>
                    </tr>
                    <!-- Additional rows as needed -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- modal -->
    <dialog id="my_modal_3" class="modal">
        <div class="modal-box">
            <form method="dialog" class="p-4">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" data-close>✕</button>
                
                <div class="mb-4">
                    <label for="user" class="block text-sm font-medium text-gray-700">Select User</label>
                    <select id="user" name="user" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <!-- Add options for users here -->
                        <option value="user1">User 1</option>
                        <option value="user2">User 2</option>
                        <option value="user3">User 3</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="category" class="block text-sm font-medium text-gray-700">Fine Category</label>
                    <select id="category" name="category" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <!-- Add options for fine categories here -->
                        <option value="category1">Category 1</option>
                        <option value="category2">Category 2</option>
                        <option value="category3">Category 3</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="total_denda" class="block text-sm font-medium text-gray-700">Total Fine</label>
                    <input type="text" id="total_denda" name="total_denda" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </div>

                <div class="mb-4">
                    <label for="keterangan" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea id="keterangan" name="keterangan" rows="3" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </dialog>



    <script>
        document.getElementById('nav-toggle').onclick = function() {
            var navMenu = document.getElementById('nav-menu');
            navMenu.classList.toggle('hidden');
        };
    </script>
</body>

</html>
