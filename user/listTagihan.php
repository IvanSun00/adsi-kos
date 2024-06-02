<?php
require_once '../includes/db_connect.php';
require_once '../classes/TagihanKamar.php';

$database = new Database();
$db = $database->dbConnection();

$tagihanKamar = new TagihanKamar($db);

$stmt = $tagihanKamar->read();
?>
<script src="https://cdn.tailwindcss.com/3.3.0"></script>
<link href="https://cdn.jsdelivr.net/npm/daisyui@4.11.1/dist/full.min.css" rel="stylesheet" type="text/css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Bills</title>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
        <h1 class="text-2xl font-bold mb-4">User Bills List</h1>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300">
                <thead class="bg-black text-white">
                    <tr>
                        <th class="py-2 px-2 md:px-4 border border-gray-300">ID Kamar</th>
                        <th class="py-2 px-2 md:px-4 border border-gray-300">Bulan</th>
                        <th class="py-2 px-2 md:px-4 border border-gray-300">Maksimal Bayar</th>
                        <th class="py-2 px-2 md:px-4 border border-gray-300">Total Bayar</th>
                        <th class="py-2 px-2 md:px-4 border border-gray-300">Denda Keterlambatan</th>
                        <th class="py-2 px-2 md:px-4 border border-gray-300">Tanggal Bayar</th>
                        <th class="py-2 px-2 md:px-4 border border-gray-300">Status</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);
                        echo "<tr class='hover:bg-gray-200'>";
                        echo "<td class='py-2 px-2 md:px-4 border border-gray-300'>{$detail_kamar}</td>";
                        echo "<td class='py-2 px-2 md:px-4 border border-gray-300'>{$bulan}</td>";
                        echo "<td class='py-2 px-2 md:px-4 border border-gray-300'>{$tanggal_maksimal_bayar}</td>";
                        echo "<td class='py-2 px-2 md:px-4 border border-gray-300'>{$harga_tagihan}</td>";
                        echo "<td class='py-2 px-2 md:px-4 border border-gray-300'>{$denda_keterlambatan}</td>";
                        echo "<td class='py-2 px-2 md:px-4 border border-gray-300'>{$tanggal_bayar}</td>";
                        echo "<td class='py-2 px-2 md:px-4 border border-gray-300'>";

                        echo "<button data-id={$id}  class='bg-blue-500 text-white px-2 md:px-3 py-1 rounded hover:bg-blue-700' type='complete'>payment</button> ";
                        echo "</td>";
                        echo "</tr>";
                    }   
                    ?>
                </tbody>
            </table>
        </div>
    </div>


    <script>
        document.getElementById('nav-toggle').onclick = function() {
            var navMenu = document.getElementById('nav-menu');
            navMenu.classList.toggle('hidden');
        };

        $(document).ready(function(){
            $('button[type="complete"]').click(function(event){
                event.preventDefault();
                const id_tagihan = $(this).data('id');
                console.log(id_tagihan)

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Do you want to mark this bill as complete?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, complete it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajax({
                            url: '../service/TagihanService.php?Request=complete',
                            type: 'POST',
                            data: {
                                id: id_tagihan
                            },
                            success: function(response) {
                                if(response.success){
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success',
                                        text: 'Fine updated successfully',
                                    }).then((result) => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: 'Failed to update fine',
                                    });
                                }
                            },
                            error: function(err) {
                                console.log(err)
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Failed to update fine',
                                });
                            }
                            
                        
                        })
                        

                        // Perform the completion action here
                        Swal.fire('Completed!', 'The bill has been marked as complete.', 'success');
                        // You can also submit the form or make an AJAX request to complete the bill
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        Swal.fire('Cancelled', 'The bill is not completed', 'error');
                    }
                });
            });


     

        })
    </script>


</body>

</html>
