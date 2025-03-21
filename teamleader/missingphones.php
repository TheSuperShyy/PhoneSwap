<?php
require __DIR__ . '/../dbcon/dbcon.php';
require __DIR__ . '/../queries/phone_query.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Missing Phones</title>
  <link rel="stylesheet" href="../src/output.css" />
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
          <a class="flex items-center bg-opacity-30 bg-white p-2 text-base font-medium rounded-lg"
            href="dashboard.php">
            <i class="fas fa-tachometer-alt mr-3"></i>
            Dashboard
          </a>
        </li>
        <li class="mb-4">
          <a class="flex items-center hover:bg-opacity-30 hover:bg-white p-2 text-base font-medium rounded-lg"
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
      <div class="fixed w-4/5 bg-gray-200 z-10 px-6 py-3 flex justify-between items-center">
        <!-- Menubar -->
        <div class="flex flex-row items-center gap-4">
          <button class="text-black focus:outline-none">
            <i class="fas fa-bars"></i>
          </button>
          <h2 class="text-xl font-semibold mr-4">Dashboard</h2>
        </div>

        <!-- Avatarbar -->
        <div class="relative dropdown">
          <button
            class="flex flex-row items-center gap-3 border border-black shadow-gray-700 shadow-sm bg-amber-400 text-black px-4 w-fit rounded-xl">
            <i class="fa-regular fa-user fa-xl"></i>
            <div class="flex flex-col items-start">
              <h1 class="font-medium">Emily Dav</h1>
              <h1 class="text-sm">Team Leader 1</h1>
            </div>
            <i class="fa-solid fa-angle-down fa-sm pl-3"></i>
          </button>
          <div class="dropdown-menu absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 z-20 hidden">
            <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Profile</a>
            <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Settings</a>
            <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Logout</a>
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
            <a href="missingphones.php"
              class="font-semibold laptop:text-lg phone:text-sm border-b-2 border-black">Missing Phones</a>
          </div>
          <div class="flex flex-row gap-4">
            <!-- Filter and Search -->
            <div class="flex laptop:flex-row phone:flex-col gap-2 w-full">
              <div class="flex justify-start">
                <form method="" class="flex flex-row items-center">
                  <select name="filter" id="filterSelect"
                    class="px-4 py-2 h-10 w-36 text-sm border border-gray-700 rounded-l-lg outline-none">
                    <option value="">Select Filter</option>
                    <option value="">Device Model</option>
                    <option value="">Serial Number</option>
                    <option value="">Table Number</option>
                    <option value="">Status</option>
                    <option value="">Assigned</option>
                    <option value="">Report</option>
                  </select>
                  <input type="text" name="" id="" placeholder="Search" value
                    class="w-2/3 h-10 p-2 border border-gray-700 shadow-sm sm:text-sm outline-none rounded-r-lg" />
                </form>
              </div>
              <div class="flex flex-row ml-auto gap-2">
                <button
                  class="flex items-center gap-2 border border-white bg-amber-400 hover:bg-amber-600 hover:bg-opacity-95 text-white px-4 py-2 rounded-lg shadow-md">
                  <i class="fa-solid fa-circle-check"></i><span>Found</span>
                </button>
                <a href="">
                  <button
                    class="flex items-center gap-2 border border-white bg-blue-950 hover:bg-blue-800 hover:bg-opacity-95 text-white px-4 py-2 rounded-lg shadow-md">
                    <i class="fa-solid fa-filter"></i></i><span>Export</span>
                  </button>
                </a>
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
                  <th class="py-3 px-4 border-b">
                    <input type="checkbox" onclick="toggleSelectAll(this)" />
                  </th>
                  <th class="py-3 px-4 border-b">Device Model</th>
                  <th class="py-3 px-4 border-b">Serial Number</th>
                  <th class="py-3 px-4 border-b">Table Number</th>
                  <th class="py-3 px-4 border-b">Status</th>
                  <th class="py-3 px-4 border-b">Team Member</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($phones as $phone): ?>
                  <?php if ($phone['status'] === 'Missing'): ?>
                  <tr class="border-b text-left">
                    <td class="py-2 px-4 whitespace-nowrap">
                      <input type="checkbox" />
                    </td>
                    <td class="py-2 px-4 flex items-center space-x-2">
                      <?php echo htmlspecialchars($phone['model']); ?>
                    </td>
                    <td class="py-2 px-4 whitespace-nowrap">
                      <?php echo htmlspecialchars($phone['serial_number']); ?>
                    </td>
                    <td class="py-2 px-4 whitespace-nowrap">
                      <?php echo $tableNumber == 0 ? 'Unassigned' : htmlspecialchars($tableNumber); ?>
                    </td>
                    <td class="py-2 px-4 whitespace-nowrap">
                      <?php if ($phone['status'] === 'Missing'): ?>
                        <span
                          class="text-red-800 bg-red-50 border border-red-800 rounded-full py-2 px-6 font-medium shadow-lg">
                          Missing
                        </span>
                        <?php endif; ?>
                    </td>
                    <td class="py-2 px-4 whitespace-nowrap">
                      <?php echo !empty($phone['assigned_to']) ? htmlspecialchars($phone['assigned_to']) : 'Unassigned'; ?>
                    </td>
                  </tr>
                  <?php endif; ?>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Pagination -->
        <div class="flex justify-end space-x-2 px-14 mb-4">
          <button class="rounded-lg px-4 py-2 hover:bg-yellow-100 hover:border-black hover:font-semibold">
            <i class="fa-solid fa-angle-left"></i>
          </button>
          <button class="rounded-lg px-4 py-2 hover:bg-yellow-100 hover:border-black hover:font-semibold">
            1
          </button>
          <button class="border border-gray-300 rounded-lg px-4 py-2 bg-amber-400 text-white font-medium">
            2
          </button>
          <button class="rounded-lg px-4 py-2 hover:bg-yellow-100 hover:border-black hover:font-semibold">
            3
          </button>
          <button class="rounded-lg px-4 py-2 hover:bg-yellow-100 hover:border-black hover:font-semibold">
            4
          </button>
          <button class="rounded-lg px-4 py-2 hover:bg-yellow-100 hover:border-black hover:font-semibold">
            <i class="fa-solid fa-angle-right"></i>
          </button>
        </div>
      </div>
    </div>

</body>

<!-- Selection for total assets -->
<script>
  const selectButton = document.getElementById('selectButton');
  const selectDropdown = document.getElementById('selectDropdown');
  const selectedValue = document.getElementById('selectedValue');

  selectButton.addEventListener('click', () => {
    selectDropdown.classList.toggle('hidden');
  });

  selectDropdown.addEventListener('click', (event) => {
    if (event.target.tagName === 'A') {
      event.preventDefault(); // Prevent link behavior
      const value = event.target.dataset.value;
      const text = event.target.textContent;

      selectButton.textContent = text; // Update button text
      selectedValue.value = value;      // Update hidden input value
      selectDropdown.classList.add('hidden'); // Close dropdown
    }
  });

  // Close dropdown if clicked outside
  window.addEventListener('click', (event) => {
    if (!selectButton.contains(event.target) && !selectDropdown.contains(event.target)) {
      selectDropdown.classList.add('hidden');
    }
  });
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Checkbox script -->
<script>
  function toggleSelectAll(source) {
    checkboxes = document.querySelectorAll('input[type="checkbox"]');
    for (var i = 0; i < checkboxes.length; i++) {
      if (checkboxes[i] != source) checkboxes[i].checked = source.checked;
    }
  }
</script>

</html>