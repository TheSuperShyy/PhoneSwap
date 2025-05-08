<?php
require __DIR__ . '/../../dbcon/dbcon.php';
require __DIR__ . '/../../queries/phone_query.php';
require __DIR__ . '/../../dbcon/authentication.php';
require __DIR__ . '/../../dbcon/session_get.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Swapped Phones</title>
  <link rel="stylesheet" href="../../src/output.css" />
  <script src="https://kit.fontawesome.com/10d593c5dc.js" crossorigin="anonymous"></script>
  <style>
    .dropdown-menu {
      display: none;
    }

    .dropdown:focus-within .dropdown-menu {
      display: block;
    }
  </style>
</head>

<body>
  <div class="flex">
    <!-- Sidebar -->
    <div class="w-1/5 bg-blue-950 text-white h-screen p-4 fixed">
      <h1 class="text-4xl mb-6 mt-2 font-medium font-russo">PhoneSwap</h1>
      <ul>
        <li class="mb-4">
          <a class="flex items-center hover:bg-opacity-30 hover:bg-white p-2 text-base font-medium rounded-lg"
            href="../dashboard/dashboard.php">
            <i class="fas fa-tachometer-alt mr-3"></i>
            Dashboard
          </a>
        </li>
        <li class="mb-4">
          <a class="flex items-center bg-opacity-30 bg-white p-2 text-base font-medium rounded-lg"
            href="swapphones.php">
            <i class="fa-solid fa-arrows-rotate mr-3"></i>
            Swap Phones
          </a>
        </li>
        <li class="mb-4">
          <a class="flex items-center hover:bg-opacity-30 hover:bg-white p-2 text-base font-medium rounded-lg"
            href="usermanagement.php">
            <i class="fa-solid fa-user-group mr-3"></i>
            User Management
          </a>
        </li>
      </ul>
    </div>

    <!-- Main Content -->
    <div class="w-4/5 ml-auto">
      <!-- Navbar section -->
      <div class="fixed w-4/5 bg-white z-10 px-6 py-3 flex justify-between items-center shadow-md">
        <!-- Menubar -->
        <div class="flex flex-row items-center gap-4">
          <button class="text-black focus:outline-none">
            <i class="fas fa-bars"></i>
          </button>
          <h2 class="text-xl font-semibold mr-4">Swapped Phones</h2>
        </div>
        <div class="flex flex-row items-center gap-4">
          <!-- Notification Bell -->
          <div class="relative inline-block text-left">
          </div>

          <!-- Avatarbar -->
          <div class="relative dropdown">
            <button
              class="flex flex-row items-center gap-3 border border-black shadow-gray-700 shadow-sm bg-amber-400 text-black px-4 w-fit rounded-xl">
              <i class="fa-regular fa-user fa-xl"></i>
              <div class="flex flex-col items-start">
                <h1 class="font-medium"><?= htmlspecialchars($userName) ?></h1>
                <h1 class="text-sm"><?= htmlspecialchars($userRole) ?></h1>
              </div>
              <i class="fa-solid fa-angle-down fa-sm pl-3"></i>
            </button>
            <div class="dropdown-menu absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 z-20 hidden">
              <a href="accountsetting.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Account Settings</a>
              <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Logout</a>
            </div>
          </div>
        </div>
      </div>


      <div class="pt-22 py-6 laptop:px-10 phone:px-6">
        <!-- contents -->
        <div class="flex flex-col gap-1 items-end justify-center w-full mx-auto">
          <div class="flex flex-col gap-3 mx-auto py-4 w-full">
            <!-- navig section, filter, search and export button -->
            <div class="flex laptop:flex-row phone:flex-col gap-3">
              <div class="flex flex-row w-[30%] gap-5 border-b border-black">
                <a href="swapphones.php"
                  class="font-semibold laptop:text-lg phone:text-sm hover:border-b-2 hover:border-black">Swap Phones</a>
                <a href="swappedphones.php"
                  class="font-semibold laptop:text-lg phone:text-sm border-b-2 border-black">Swapped Phones</a>
              </div>
              <div class="flex  flex-row gap-4">
                <!-- Filter and Search -->
                <div class="flex  laptop:flex-row phone:flex-col gap-2 w-full">
                  <div class="flex  justify-start">
                    <form method="" class="flex flex-row items-center">
                      <select name="filter" id="filterSelect"
                        class="px-4 py-2 h-10 w-48 text-sm border border-gray-700 rounded-l-lg outline-none">
                        <option value="">Select Filter</option>
                        <option value="model">Device Model</option>
                        <option value="serial_number">Serial Number</option>
                        <option value="status">Status</option>
                        <option value="team_leader">Team Leader</option>
                      </select>
                      <input type="text" name="" id="searchInput" placeholder="Search"
                        class="w-full h-10 p-2 border border-gray-700 shadow-sm sm:text-sm outline-none rounded-r-lg" />
                    </form>
                  </div>
                  
                </div>
              </div>
              <div class="flex flex-row ml-auto gap-2">
                    <button
                      class="flex items-center gap-2 border border-white bg-white hover:white hover:bg-opacity-95 text-white px-4 py-2 rounded-lg hidden">
                      <i class="fa-solid fa-arrow-right-arrow-left"></i></i><span>Returned</span>
                    </button>
                    <a href="">
                      <button
                        class="flex items-center gap-2 border border-white bg-blue-950 hover:bg-blue-950 hover:bg-opacity-95 text-white px-4 py-2 rounded-lg shadow-md">
                        <i class="fa-solid fa-filter"></i></i><span>Export</span>
                      </button>
                    </a>
                  </div>
            </div>

            <!-- Swap Phones Table -->
            <div class="w-full overflow-x-auto h-full border border-gray-300 rounded-lg shadow-md">
              <table class="w-full bg-white pl-7">
                <thead">
                  <tr class="bg-gray-200 border-b border-gray-400 text-sm text-left px-4">

                    <th class="py-3 px-4 whitespace-nowrap">Old Phone</th>
                    <th class="py-3 px-4 whitespace-nowrap">New Phone</th>
                    <th class="py-3 px-4 whitespace-nowrap">Date and Time</th>
                    <th class="py-3 px-4 whitespace-nowrap">Actions</th>
                    <th class="py-3 px-4 whitespace-nowrap">Performed By</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                    $auditLogs = $phoneswapauditCollection->find([], ['sort' => ['timestamp' => -1]]); // latest first
                    
                    foreach ($auditLogs as $log):
                      // Access the old and new serial from the 'details' array field inside the log
                      $oldSerial = isset($log['details']['old_serial']) && !empty($log['details']['old_serial']) ? $log['details']['old_serial'] : 'N/A';
                      $newSerial = isset($log['details']['new_serial']) && !empty($log['details']['new_serial']) ? $log['details']['new_serial'] : 'N/A';

                      $performedBy = $log['performed_by'] ?? 'Unknown';
                      $timestamp = $log['timestamp'] instanceof MongoDB\BSON\UTCDateTime
                        ? $log['timestamp']->toDateTime()->format('F j, Y g:i A')
                        : $log['timestamp'];
                      ?>
                      <tr class="border-b user-row">
                        <td class="py-5 px-4 whitespace-nowrap"><?= htmlspecialchars($oldSerial) ?></td>
                        <td class="py-5 px-4 whitespace-nowrap"><?= htmlspecialchars($newSerial) ?></td>
                        <td class="py-5 px-4 whitespace-nowrap"><?= htmlspecialchars($timestamp) ?></td>
                        <td class="py-2 px-4 whitespace-nowrap">
                          <span
                            class="text-green-800 bg-green-50 border border-green-800 rounded-full bg-opacity-100 py-2 px-6 font-medium shadow-lg">
                            Swapped
                          </span>
                        </td>
                        <td class="py-5 px-4 whitespace-nowrap"><?= htmlspecialchars($performedBy) ?></td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>

              </table>
            </div>
          </div>

          <!-- Pagination -->
          <div class="pagination flex justify-end space-x-2 px-14 mb-4" id="pagination">
            <button class="prev-btn rounded-lg px-4 py-2 hover:bg-yellow-100 hover:border-black hover:font-semibold">
              <i class="fa-solid fa-angle-left"></i>
            </button>
            <!-- Numbered buttons will be generated here by JS -->
            <button class="next-btn rounded-lg px-4 py-2 hover:bg-yellow-100 hover:border-black hover:font-semibold">
              <i class="fa-solid fa-angle-right"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

<!-- script for pagination -->
<script src="../../scripts/script.js"></script>
<script src="../../scripts/filtering.js"></script>

</html>