<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Manage Phones</title>
    <link rel="icon" href="../src/assets/images/iconswap.svg" type="image/svg">
    <link rel="stylesheet" href="../src/output.css" />
    <script
      src="https://kit.fontawesome.com/10d593c5dc.js"
      crossorigin="anonymous"
    ></script>
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
            <a
              class="flex items-center hover:bg-opacity-30 hover:bg-white p-2 text-base font-medium rounded-lg"
              href="audittrail.html"
            >
              <i class="fas fa-list-alt mr-3"></i>
              Audit Trail
            </a>
          </li>
          <li class="mb-4">
            <a
              class="flex items-center hover:bg-opacity-30 hover:bg-white p-2 text-base font-medium rounded-lg"
              href="swapphones.html"
            >
              <i class="fas fa-warehouse mr-3"></i>
              Swap Phones
            </a>
          </li>
          <li class="mb-4">
            <a
              class="flex items-center hover:bg-opacity-30 hover:bg-white p-2 text-base font-medium rounded-lg"
              href="usermanagement.html"
            >
              <i class="fas fa-tools mr-3"></i>
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
            <h2 class="text-xl font-semibold mr-4">Manage Phones</h2>
          </div>

          <div class="flex gap-4">
            <div class="flex flex-row items-center gap-4">
              <!-- Notification Bell -->
              <div class="relative inline-block text-left">
                <button
                  class="relative text-2xl"
                  aria-label="Notifications"
                  id="notificationButton"
                >
                  <i class="fa-regular fa-bell"></i>
                </button>

                <!-- Dropdown Message Notification -->
                <div
                  class="origin-top-right absolute right-0 mt-2 w-80 rounded-md shadow-lg bg-white border border-gray-400 ring-1 ring-black ring-opacity-5 focus:outline-none hidden"
                  role="menu"
                  aria-orientation="vertical"
                  aria-labelledby="notificationButton"
                  id="notificationDropdown"
                >
                  <div class="py-1" role="none">
                    <a
                      href="#"
                      class="block px-4 py-2 text-sm text-black-700 hover:bg-gray-100"
                      role="menuitem"
                    >
                      <div class="flex">
                        <div>
                          <p class="font-medium">
                            New message from Yul Gatchalian
                          </p>
                          <p class="text-sm text-black-500">Lorem ipsum dolor sit amet.</p>
                          <p class="text-xs text-black-400">5 minutes ago</p>
                        </div>
                      </div>
                    </a>
                    <a
                      href="#"
                      class="block px-4 py-2 text-sm text-black-700 hover:bg-gray-100"
                      role="menuitem"
                    >
                      <div class="flex">
                        <div class="mr-3">
                          <p class="font-medium">Cylie Gonzales</p>
                          <p class="text-sm text-black-500">
                            Lorem ipsum dolor sit amet. 
                          </p>
                          <p class="text-xs text-black-400">1 hour ago</p>
                        </div>
                      </div>
                    </a>
                    <a
                    href="#"
                    class="block px-4 py-2 text-sm text-black-700 hover:bg-gray-100"
                    role="menuitem"
                  >
                    <div class="flex">
                      <div class="mr-3">
                        <p class="font-medium">Kian David</p>
                        <p class="text-sm text-black-500">
                          Lorem ipsum dolor sit amet. 
                        </p>
                        <p class="text-xs text-black-400">2 days ago</p>
                      </div>
                    </div>
                  </a>
                  <a
                    href="#"
                    class="block px-4 py-2 text-sm text-black-700 hover:bg-gray-100"
                    role="menuitem"
                  >
                    <div class="flex">
                      <div class="mr-3">
                        <p class="font-medium">Miko Basilio</p>
                        <p class="text-sm text-black-500">
                          Lorem ipsum dolor sit amet. 
                        </p>
                        <p class="text-xs text-black-400">2 days ago</p>
                      </div>
                    </div>
                  </a>
                  <a
                    href="#"
                    class="block px-4 py-2 text-sm text-black-700 hover:bg-gray-100"
                    role="menuitem"
                  >
                    <div class="flex">
                      <div class="mr-3">
                        <p class="font-medium">Daniel Digo</p>
                        <p class="text-sm text-black-500">
                          Lorem ipsum dolor sit amet. 
                        </p>
                        <p class="text-xs text-black-400">2 days ago</p>
                      </div>
                    </div>
                  </a>
                </div>
              </div>
            </div>
          </div>

          <!-- Avatarbar -->
          <div class="relative dropdown">
            <button class="flex flex-row items-center gap-3 border border-black shadow-gray-700 shadow-sm bg-amber-400 text-black px-4 w-fit rounded-xl">
              <i class="fa-regular fa-user fa-xl"></i>
              <div class="flex flex-col items-start">
                <h1 class="font-medium">Emily Dav</h1>
                <h1 class="text-sm">Admin</h1>
              </div>
              <i class="fa-solid fa-angle-down fa-sm pl-3"></i>
            </button>
            <div class="dropdown-menu absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 z-20 hidden">
              <a href="accountsetting.html"
                class="block px-4 py-2 text-gray-800 hover:bg-gray-200"
                >Account Settings</a>
              <a  href="#"
                class="block px-4 py-2 text-gray-800 hover:bg-gray-200"
                >Logout</a>
            </div>
          </div>
        </div>
      </div>

        <!-- Main Content -->
        <div class="pt-22 py-6 laptop:px-10 phone:px-6">
          <h3 class="text-xl font-semibold mb-4">Overview</h3>
          <div class="flex laptop:flex-row phone:flex-col gap-4 mb-6">
            <div class="bg-white p-6 rounded-lg text-start border border-gray-200 shadow-lg w-full">
              <h4 class="text-4xl font-lg font-russo ">1234</h4>
              <p class="text-base font-medium">Total Phone</p>
            </div>
            <div class="bg-white p-6 rounded-lg text-start border border-gray-200 shadow-lg w-full">
              <h4 class="text-4xl font-lg font-russo ">5000</h4>
              <p class="text-base font-medium">Active Phone</p>
            </div>
            <div class="bg-white p-6 rounded-lg text-start border border-gray-200 shadow-lg w-full">
              <h4 class="text-4xl font-lg font-russo ">5243</h4>
              <p class="text-base font-medium">Inactive Phone</p>
            </div>
            <div class="bg-white p-6 rounded-lg text-start border border-gray-200 shadow-lg w-full">
              <h4 class="text-4xl font-lg font-russo ">5243</h4>
              <p class="text-base font-medium">Swap Phones</p>
            </div>
            <div class="bg-white p-6 rounded-lg text-start border border-gray-200 shadow-lg w-full">
                <h4 class="text-4xl font-lg font-russo ">5243</h4>
                <p class="text-base font-medium">Missing Phones</p>
              </div>
          </div>

          <!-- navig section, filter, search and export button -->
          <div class="flex laptop:flex-row phone:flex-col gap-3 justify-between">
            <div class="flex flex-row gap-5 border-b border-black">
                <a href="dashboard.html" class="font-semibold laptop:text-lg phone:text-sm hover:border-b-2 hover:border-black">Assign Phones</a>
                <a href="managephones.html" class="font-semibold laptop:text-lg phone:text-sm border-b-2 border-black">Manage Phones</a>
                <a href="missingphones.html" class="font-semibold laptop:text-lg phone:text-sm hover:border-b-2 hover:border-black">Missing Phones</a>
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
                        <option value="">Team Leader</option>
                        <option value="">Action</option>
                    </select>
                    <input type="text" name="" id="" placeholder="Search" value
                      class="w-2/3 h-10 p-2 border border-gray-700 shadow-sm sm:text-sm outline-none rounded-r-lg"/>
                  </form>
                </div>
                <div class="flex flex-row ml-auto gap-2">
                  <a href="">
                    <button class="flex items-center gap-2 border border-black bg-white hover:bg-gray-100 hover:bg-opacity-95 text-black px-4 py-2 rounded-lg shadow-md">
                        <i class="fa-solid fa-filter"></i></i><span>Export</span>
                    </button>
                  </a>
                    <button id="openModalBtn2" class="flex items-center gap-2 border border-black bg-blue-950 hover:bg-blue-950 hover:bg-opacity-95 text-white px-4 py-2 rounded-lg shadow-md">
                      <i class="fa-solid fa-circle-plus"></i><span>Add New</span>
                    </button>
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
                    <th class="py-3 px-4 border-b">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr class="border-b text-left">
                    <td class="py-2 px-4 whitespace-nowrap">
                      Iphone 8
                    </td>
                    <td class="py-2 px-4 whitespace-nowrap">120295</td>
                    <td class="py-2 px-4 whitespace-nowrap">
                        <select id="openModalBtn" class="border b rounded-lg p-2">
                          <option>Table 1</option>
                          <option>Table 2</option>
                        </select>
                      </td>
                    <td class="py-2 px-4 whitespace-nowrap">
                        <span class="text-green-800 bg-green-100 border border-green-800 rounded-full bg-opacity-100 py-2 px-6 font-medium shadow-lg">Active</span>
                    </td>
                    <td class="py-2 px-4 whitespace-nowrap">Pending</td>
                    </td>
                    <td class="text-center space-x-2">
                      <div class="flex flex-row py-2 px-4 gap-2">
                        <button id="openModalBtn1" class="flex flex-row gap-2 items-center font-semibold border border-white bg-blue-500 hover:bg-blue-700 text-white px-6 py-1.5 rounded-full shadow-lg">
                          <i class="fa-regular fa-pen-to-square"></i> Edit
                        </button>
                        <button class="flex flex-row gap-2 items-center border font-semibold border-white bg-red-700 hover:bg-red-900 text-white px-4 py-1.5 rounded-full shadow-lg">
                          <i class="fa-solid fa-trash"></i> Delete
                        </button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <!-- Modal for edit phone details -->
          <div id="myModal1" class="fixed inset-0 flex justify-center items-center hidden bg-black bg-opacity-50 z-50 pt-24 pb-24 h-full laptop:px-80 laptop:w-full phone:w-full phone:px-4">
            <div class="bg-white border border-gray-600 rounded-lg px-6 py-6 shadow-lg relative h-fit w-full">
                <div class="flex flex-col gap-4">
                    <h2 class="text-3xl font-russo mb-2">Edit Phone</h2>
        
                    <div class="flex flex-col gap-4">
                      <div class="flex laptop:flex-row phone:flex-col gap-4">
                        <div class="flex flex-col gap-2 w-full">
                          <label for="" class="text-sm font-medium">Device Model</label>
                          <input type="text" placeholder="Device Model" class="border border-gray-700  p-2 rounded-lg">
                        </div>
                        <div class="flex flex-col gap-2 w-full">
                          <label for="" class="text-sm font-medium">Serial Number</label>
                          <select name="filter" id="filterSelect"
                            class="p-2 h-10 w-full text-sm border border-gray-700 rounded-lg outline-none">
                            <option value="">Select Serial Number</option>
                            <option value="">123456</option>
                            <option value="">789210</option>
                          </select>
                        </div>
                      </div>
                        <div class="flex flex-col gap-2 w-full">
                          <label for="" class="text-sm font-medium">Table Number</label>
                          <select name="filter" id="filterSelect"
                            class="p-2 h-10 w-full text-sm border border-gray-700 rounded-lg outline-none">
                            <option value="">Select Table Number</option>
                            <option value="">Table 1</option>
                            <option value="">Table 2</option>
                          </select>
                        </div>
                    </div>
                </div>
                <br>
                <div class="flex justify-end gap-2 mt-4">
                  <button id="closeModalBtn1" class="w-24 px-4 py-2 shadow-md shadow-gray-300 hover:ring-slate-400 text-black border border-black font-medium rounded-lg">
                    Cancel
                  </button>
                  <button class="px-4 py-2 w-24 shadow-md shadow-gray-300 bg-amber-400 font-medium text-black border border-black rounded-lg">
                    Save
                  </button>
                </div>
            </div>
          </div>

          <!-- Modal for add phone -->
          <div id="myModal2" class="fixed inset-0 flex justify-center items-center hidden bg-black bg-opacity-50 z-50 pt-24 pb-24 h-full laptop:px-80 laptop:w-full phone:w-full phone:px-4">
            <div class="bg-white border border-gray-600 rounded-lg px-6 py-6 shadow-lg relative h-fit w-full">
                <div class="flex flex-col gap-4">
                    <h2 class="text-3xl font-russo mb-2">Add New Phone</h2>
        
                    <div class="flex flex-col gap-4">
                      <div class="flex laptop:flex-row phone:flex-col gap-4">
                        <div class="flex flex-col gap-2 w-full">
                          <label for="" class="text-sm font-medium">Device Model</label>
                          <input type="text" placeholder="Device Model" class="border border-gray-700  p-2 rounded-lg">
                        </div>
                        <div class="flex flex-col gap-2 w-full">
                          <label for="" class="text-sm font-medium">Serial Number</label>
                          <select name="filter" id="filterSelect"
                            class="p-2 h-10 w-full text-sm border border-gray-700 rounded-lg outline-none">
                            <option value="">Select Serial Number</option>
                            <option value="">123456</option>
                            <option value="">789210</option>
                          </select>
                        </div>
                      </div>
                        <div class="flex flex-col gap-2 w-full">
                          <label for="" class="text-sm font-medium">Table Number</label>
                          <select name="filter" id="filterSelect"
                            class="p-2 h-10 w-full text-sm border border-gray-700 rounded-lg outline-none">
                            <option value="">Select Table Number</option>
                            <option value="">Table 1</option>
                            <option value="">Table 2</option>
                          </select>
                        </div>
                    </div>
                </div>
                <br>
                <div class="flex justify-end gap-2 mt-4">
                  <button id="closeModalBtn2" class="w-24 px-4 py-2 shadow-md shadow-gray-300 hover:ring-slate-400 text-black border border-black font-medium rounded-lg">
                    Cancel
                  </button>
                  <button class="px-4 py-2 w-24 shadow-md shadow-gray-300 bg-amber-400 font-medium text-black border border-black rounded-lg">
                    Save
                  </button>
                </div>
            </div>
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

  <!-- avatarbar --> 
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

  <!-- Script for modal edit assets -->
  <script>
    const modal1 = document.getElementById('myModal1');
    const openModalBtn1 = document.getElementById('openModalBtn1');
    const closeModalBtn1 = document.getElementById('closeModalBtn1');
    const modalCancelButton1 = document.getElementById('modalBackButton1');

    openModalBtn1.addEventListener('click', () => {
        modal1.classList.remove('hidden');
    });

    closeModalBtn1.addEventListener('click', () => {
        modal1.classList.add('hidden');
    });

    modalCancelButton1.addEventListener('click', () => {
        modal1.classList.add('hidden');
    });
  </script>

  <!-- Script for add modal -->
  <script>
    const modal2 = document.getElementById('myModal2');
    const openModalBtn2 = document.getElementById('openModalBtn2');
    const closeModalBtn2 = document.getElementById('closeModalBtn2');
    const modalCancelButton2 = document.getElementById('modalBackButton2');

    openModalBtn2.addEventListener('click', () => {
        modal2.classList.remove('hidden');
    });

    closeModalBtn2.addEventListener('click', () => {
        modal2.classList.add('hidden');
    });

    modalCancelButton2.addEventListener('click', () => {
        modal2.classList.add('hidden');
    });
  </script>

  <!-- Script for notification bell dropdown-->
  <script>
    const notificationButton = document.getElementById("notificationButton");
    const notificationDropdown = document.getElementById(
      "notificationDropdown"
    );

    notificationButton.addEventListener("click", () => {
      notificationDropdown.classList.toggle("hidden");
    });
  </script>

</html>