<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang</title>

    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


    <style>
                 body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .navbar {
            background-color: #333;
            padding: 10px;
            text-align: center;
        }

        .navbar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .navbar li {
            display: inline;
            margin-right: 20px;
        }

        .navbar a {
            text-decoration: none;
            color: white;
            font-weight: bold;
            font-size: 16px;
        }

        .container {
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
    background-color: #f2f2f2;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    margin-bottom: 100px; 
}

        h1 {
            color: #333;

        }

        .popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .popup-content {
            display: block; 
            background-color: white;
            width: 400px;
            padding: 20px;
            border-radius: 10px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        #barangsTable {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        #barangsTable th, #barangsTable td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        #barangsTable th {
            background-color: #333;
            color: white;
        }

        #barangsTable tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        #barangsTable tbody tr:hover {
            background-color: #ddd;
        }

        button {
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

       
        button.edit-btn {
            background-color: #3498db;
            color: white;
        }

        button.edit-btn:hover {
            background-color: #2980b9;
        }


        button.add-btn {
            background-color: #2ecc71;
            color: white;
        }

        button.add-btn:hover {
            background-color: #27ae60;
        }


        button.delete-btn {
            background-color: #e74c3c;
            color: white;
        }

        button.delete-btn:hover {
            background-color: #c0392b;
        }


        .close-btn {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            cursor: pointer;
        }
    </style>
</head>
<body>

    @include('navbar')


<div class="container">
    <h1>Data Barang</h1>
    <div class="search-container">
        <input type="text" id="searchInput" placeholder="Cari " onkeyup="searchBarang()">
        <button onclick="searchBarang()">Search</button>
    </div>
    <button class="add-btn" onclick="openAddForm()">Tambah Data Barang</button>

    <table id="barangsTable">
        <thead>
        <tr>
            <th>No</th>
            <th>Nama barang</th>
            <th>Stock</th>
            <th>Jenis barang</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody id="barangsTableBody">
        </tbody>
    </table>
</div>

<div id="addbarangsPopup" class="popup">
    <div class="popup-content">
        <span class="close-btn" onclick="closeAddForm()">X</span>
        <h2>Tambah Data Barang</h2>
        <form id="addbarangsForm" onsubmit="submitForm(event)">
            <label for="nama_barangs">Nama Barang:</label>
            <input type="text" id="nama_barangs" name="nama_barang" required><br><br>
            <label for="stok">Stock Barang:</label>
            <input type="number" id="stok" name="stok" required><br><br>
            <label for="jenis_barangs">Jenis Barang:</label>
            <input type="text" id="jenis_barangs" name="jenis_barang" required><br><br>
            <button type="submit">Tambah</button>
        </form>
    </div>
</div>

<div id="editbarangsPopup" class="popup">
    <div class="popup-content">
        <span class="close-btn" onclick="closeEditForm()">X</span>
        <h2>Edit Data Barang</h2>
        <form id="editbarangsForm" onsubmit="updateBarang(event)">
            <input type="hidden" id="editbarangsId" name="barangsId">
            <label for="editnamabarangs">Nama Barang:</label>
            <input type="text" id="editnamabarangs" name="nama_barang" required><br><br>
            <label for="editstok">Stock Barang:</label>
            <input type="number" id="editstok" name="stok" required><br><br>
            <label for="editjenisbarangs">Jenis Barang:</label>
            <input type="text" id="editjenisbarangs" name="jenis_barang" required><br><br>
            <button type="submit">Simpan</button>
        </form>
    </div>
</div>


@include('footer')

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    function openAddForm() {
        document.getElementById('addbarangsPopup').style.display = 'block';
    }

    function closeAddForm() {
        document.getElementById('addbarangsPopup').style.display = 'none';
    }

    function openEditForm(id) {
        document.getElementById('editbarangsPopup').style.display = 'block';
        fetchbarangsById(id);
    }

    function closeEditForm() {
        document.getElementById('editbarangsPopup').style.display = 'none';
    }

    function submitForm(event) {
        event.preventDefault();

        
        const form = event.target;

        
        const formData = new FormData(form);

        
        axios.post('http://localhost:8000/api/barangs/store', formData)
            .then(response => {
                console.log('Item added successfully:', response.data);
                
                closeAddForm();
                
                fetchbarangs();
                
                form.reset();
            })
            .catch(error => {
                console.error('Error adding item:', error);
            });
    }

    function fetchbarangsById(id) {
        axios.get(`http://localhost:8000/api/barangs/${id}`)
            .then(response => {
                const barangs = response.data;
                document.getElementById('editbarangsId').value = barangs.id;
                document.getElementById('editnamabarangs').value = barangs.nama_barang;
                document.getElementById('editstok').value = barangs.stok;
                document.getElementById('editjenisbarangs').value = barangs.jenis_barang;
            })
            .catch(error => {
                console.error('Error fetching barangs by ID:', error);
            });
    }

    function updateBarang(event) {
        event.preventDefault();
        const form = event.target;
        const formData = new FormData(form);
        const barangsId = formData.get('barangsId');

        axios.post(`http://localhost:8000/api/barangs/edit/${barangsId}`, formData)
            .then(response => {
                console.log('barangs updated:', response.data);
                closeEditForm();
                fetchbarangs();
            })
            .catch(error => {
                console.error('Error updating barangs:', error);
            });
    }

    function deletebarangs(id) {
        axios.delete(`http://localhost:8000/api/barangs/${id}`)
            .then(response => {
                console.log('barangs deleted:', response.data);
                fetchbarangs();
            })
            .catch(error => {
                console.error('Error deleting barangs:', error);
            });
    }

    function fetchbarangs() {
        axios.get('http://localhost:8000/api/barangs')
            .then(response => {
                const barangs = response.data;
                const tableBody = document.getElementById('barangsTableBody');
                tableBody.innerHTML = '';
                let count = 1;
                barangs.forEach(barangs => {
                    const row = `<tr>
                                        <td>${count++}</td>
                                        <td>${barangs.nama_barang}</td>
                                        <td>${barangs.stok}</td>
                                        <td>${barangs.jenis_barang}</td>
                                        <td>
                                            <button class="edit-btn" onclick="openEditForm(${barangs.id})">Edit</button>
                                            <button class="delete-btn" onclick="deletebarangs(${barangs.id})">Delete</button>
                                        </td>
                                    </tr>`;
                    tableBody.innerHTML += row;
                });
            })
            .catch(error => {
                console.error('Error fetching barangs:', error);
            });
    }

    function searchBarang() {
        const input = document.getElementById('searchInput').value.toLowerCase();
        const tableRows = document.getElementById('barangsTableBody').getElementsByTagName('tr');

        for (let i = 0; i < tableRows.length; i++) {
            const namaBarang = tableRows[i].getElementsByTagName('td')[1].innerText.toLowerCase();
            if (namaBarang.includes(input)) {
                tableRows[i].style.display = '';
            } else {
                tableRows[i].style.display = 'none';
            }
        }
    }

    fetchbarangs();
</script>
</body>
</html>