<?php
require __DIR__ . '/../../dbcon/authentication.php';
require __DIR__ . '/../../dbcon/dbcon.php';
require __DIR__ . '/../../queries/phone_query.php';
require __DIR__ . '/../../dbcon/session_get.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Missing Phones</title>
  <link rel="icon" href="../../src/assets/images/iconswap.svg" type="image/svg">
  <link rel="stylesheet" href="../../src/output.css" />
  <script src="https://kit.fontawesome.com/10d593c5dc.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
          <a class="flex items-center bg-opacity-30 bg-white p-2 text-base font-medium rounded-lg" href="dashboard.php">
            <i class="fas fa-tachometer-alt mr-3"></i>
            Dashboard
          </a>
        </li>
        <li class="mb-4">
          <a class="flex items-center hover:bg-opacity-30 hover:bg-white p-2 text-base font-medium rounded-lg"
            href="../sidebar_pages/audittrail.php">
            <i class="fas fa-list-alt mr-3"></i>
            Audit Trail
          </a>
        </li>
        <li class="mb-4">
          <a class="flex items-center hover:bg-opacity-30 hover:bg-white p-2 text-base font-medium rounded-lg"
            href="../sidebar_pages/swapphones.php">
            <i class="fas fa-warehouse mr-3"></i>
            Swap Phones
          </a>
        </li>
        <li class="mb-4">
          <a class="flex items-center hover:bg-opacity-30 hover:bg-white p-2 text-base font-medium rounded-lg"
            href="../sidebar_pages/usermanagement.php">
            <i class="fas fa-tools mr-3"></i>
            User Management
          </a>
        </li>
        <li class="mb-4">
          <a class="flex items-center hover:bg-opacity-30 hover:bg-white p-2 text-base font-medium rounded-lg"
            href="../sidebar_pages/user_audit.php">
            <i class="fas fa-list-alt mr-3"></i>
            User Audit Log
          </a>
        </li>
      </ul>
    </div>

    <!-- Main Content -->
    <div class="w-4/5 ml-auto">
      <!-- Navbar section -->
      <div class="fixed w-4/5 bg-gray-200 z-10 px-6 py-3 flex justify-between items-center">
        <!-- Menubar -->
        <div class="flex flex-row items-center gap-4">
          <button class="text-black focus:outline-none">
            <i class="fas fa-bars"></i>
          </button>
          <h2 class="text-xl font-semibold mr-4">Missing Phones</h2>
        </div>

        <div class="flex gap-4">
          <div class="flex flex-row items-center gap-4">

            <div class="relative inline-block text-left">
            </div>
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
              <a href="../sidebar_pages/accountsetting.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Account Settings</a>
              <a href="../../src/logout.php" id="logoutBtn" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">
                Logout
              </a>

            </div>
          </div>
        </div>
      </div>

      <!-- Main Content -->
      <div class="pt-22 py-6 laptop:px-10 phone:px-6">
        <h3 class="text-xl font-semibold mb-4">Overview</h3>
        <div class="flex laptop:flex-row phone:flex-col gap-4 mb-6">
          <div class="bg-white p-6 rounded-lg text-start border border-gray-200 shadow-lg w-full">
            <h4 class="text-4xl font-lg font-russo "><?php echo $totalPhones; ?></h4>
            <p class="text-base font-medium">Total Phone</p>
          </div>
          <div class="bg-white p-6 rounded-lg text-start border border-gray-200 shadow-lg w-full">
            <h4 class="text-4xl font-lg font-russo "><?php echo $totalActivePhones; ?></h4>
            <p class="text-base font-medium">Active Phone</p>
          </div>
          <div class="bg-white p-6 rounded-lg text-start border border-gray-200 shadow-lg w-full">
            <h4 class="text-4xl font-lg font-russo "><?php echo $totalInactivePhones; ?></h4>
            <p class="text-base font-medium">Inactive Phone</p>
          </div>
          <div class="bg-white p-6 rounded-lg text-start border border-gray-200 shadow-lg w-full">
            <h4 class="text-4xl font-lg font-russo ">0</h4>
            <p class="text-base font-medium">Swap Phones</p>
          </div>
          <div class="bg-white p-6 rounded-lg text-start border border-gray-200 shadow-lg w-full">
            <h4 class="text-4xl font-lg font-russo "><?php echo $totalMissingPhones; ?></h4>
            <p class="text-base font-medium">Missing Phones</p>
          </div>
        </div>

        <!-- navig section, filter, search and export button -->
        <div class="flex laptop:flex-row phone:flex-col gap-3 justify-between">
          <div class="flex flex-row gap-5 border-b border-black">
            <a href="dashboard.php"
              class="font-semibold laptop:text-lg phone:text-sm hover:border-b-2 hover:border-black">Assign Phones</a>
            <a href="managephones.php"
              class="font-semibold laptop:text-lg phone:text-sm hover:border-b-2 hover:border-black">Manage Phones</a>
            <a href="missingphones.php"
              class="font-semibold laptop:text-lg phone:text-sm border-b-2 border-black">Missing Phones</a>
          </div>
          <div class="flex flex-row gap-4">
            <!-- Filter and Search -->
            <div class="flex laptop:flex-row phone:flex-col gap-2 w-full">
              <div class="flex justify-start">
                <form method="" class="flex flex-row items-center">
                  <select name="filter" id="filterSelect" disabled
                    class="px-4 py-2 h-10 w-48 text-sm border border-gray-700 rounded-l-lg outline-none">
                    <option value="">Select Filter</option>
                    <option value="">Device Model</option>
                    <option value="">Serial Number</option>
                    <option value="">Table Number</option>
                    <option value="">Status</option>
                    <option value="">Team Leader</option>
                  </select>
                  <input type="text" name="" id="" placeholder="Search" value
                    class="w-full h-10 p-2 border border-gray-700 shadow-sm sm:text-sm outline-none rounded-r-lg" />
                </form>
              </div>
              <div class="flex ml-auto gap-2">
              </div>
            </div>
          </div>
        </div>

        <!-- Audit trail table -->
        <div class="rounded-lg shadow-md mt-3">
          <div class="w-full overflow-x-auto h-full rounded-lg">
            <table class="w-full bg-white">
              <thead class="bg-gray-300">
                <tr class="text-left text-sm">
                  <th class="py-3 px-4 border-b">Device Model</th>
                  <th class="py-3 px-4 border-b">Serial Number</th>
                  <th class="py-3 px-4 border-b">Table Number</th>
                  <th class="py-3 px-4 border-b">Status</th>
                  <th class="py-3 px-4 border-b">Team Leader</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if ($totalActivePhones == 0) {
                  echo '<tr class="border-b text-left"><td class="py-2 px-4" colspan="5">No phones found.</td></tr>';
                }
                // Fetch all phones
                $phonesCursor = $db->phones->find(['status' => 'Missing']);

                foreach ($phonesCursor as $phone):
                  ?>
                  <tr class="border-b text-left user-row">
                    <td class="py-2 px-4 flex items-center space-x-2">
                      <?= htmlspecialchars($phone['model'] ?? 'Unknown') ?>
                    </td>
                    <td class="py-2 px-4 whitespace-nowrap">
                      <?= htmlspecialchars($phone['serial_number'] ?? 'N/A') ?>
                    </td>
                    <td class="py-2 px-4 whitespace-nowrap">
                      <select class="border b rounded-lg p-2">
                        <option value="">Table 1</option>
                      </select>
                    </td>
                    <td class="py-2 px-4 whitespace-nowrap">
                      <?php
                      $status = $phone['status'] ?? 'Unknown';
                      $statusClass = $status === 'Missing' ? 'text-red-800 bg-red-50 border border-red-800' : 'text-green-800 bg-green-50 border border-green-800';
                      ?>
                      <span class="<?= $statusClass ?> rounded-full bg-opacity-100 py-2 px-6 font-medium shadow-lg">
                        <?= htmlspecialchars($status) ?>
                      </span>
                    </td>
                    <td class="py-2 px-4 whitespace-nowrap">
                      <?php
                      // Fetch Team Leader assigned to this phone
                      $tl = $db->users->findOne(
                        ['assigned_phone' => $phone['serial_number']],
                        ['projection' => ['hfId' => 1, 'first_name' => 1, 'last_name' => 1]]
                      );
                      echo $tl ? htmlspecialchars('(' . $tl['hfId'] . ') ' . $tl['first_name'] . ' ' . $tl['last_name']) : 'Unassigned';
                      ?>
                    </td>
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

</body>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



<!-- logout script -->
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const logoutBtn = document.getElementById("logoutBtn");

    if (logoutBtn) {
      logoutBtn.addEventListener("click", function (event) {
        event.preventDefault(); // ✅ Prevent default link behavior

        Swal.fire({
          title: "Are you sure?",
          text: "You will be logged out of your session.",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, Logout!"
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = logoutBtn.href; // ✅ Redirect after confirmation
          }
        });
      });
    }
  });
</script>


<!-- script for pagination -->
<script src="../../scripts/script.js"></script>
</html>