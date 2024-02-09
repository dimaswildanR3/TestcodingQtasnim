<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Data Transaksi</title>
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
    padding: 5px;
    position: fixed;
    bottom: 0;
    width: 100%;
    max-height: 50px; 
    overflow: auto; 
  
}

        #transaksiTable {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        #transaksiTable th, #transaksiTable td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        #transaksiTable th {
            background-color: #333;
            color: white;
        }

        #transaksiTable tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        #transaksiTable tbody tr:hover {
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
        div.sort-buttons {
            margin-top: 10px;
        }

        button.sort-btn {
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            background-color: #2ecc71;
            color: white;
            margin-right: 10px;
        }

        button.sort-btn:hover {
            background-color: #27ae60;
        }
    </style>
</head>
<body>
  
  @include('navbar')

  <div class="container">
    <h1>Data Transaksi</h1>    
    <button class="add-btn" onclick="openAddForm()">Tambah Data Barang</button>
    
    <div class="sort-buttons">
      <button class="sort-btn" onclick="searchAndSort('asc')">Urutkan Terendah ke Tertinggi</button>
      <button class="sort-btn" onclick="searchAndSort('desc')">Urutkan Tertinggi ke Terendah</button>
  </div>

  <div class="search-form">
    <label for="start_date">Tanggal Mulai:</label>
    <input type="date" id="start_date">
    <label for="end_date">Tanggal Akhir:</label>
    <input type="date" id="end_date">
    <button onclick="searchAndSort('asc')">Cari</button>
</div>
    
    <table id="transaksiTable">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama Barang</th>
          <th>Stock</th>
          <th>Jumlah Terjual</th>
          <th>Tanggal Transaksi</th>
          <th>Jenis Barang</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody id="transaksiTableBody">        
      </tbody>
    </table>
  </div>
  
  <div id="addTransactionPopup" class="popup">
    <div class="popup-content">
      <span class="close-btn" onclick="closeAddForm()">X</span>
      <h2>Tambah Data Transaksi</h2>
      <form id="transactionForm">
        <input type="hidden" id="transactionId" name="transactionId">        
        <label for="barang_id">Nama Barang:</label>
        <select id="barang_id" name="barang_id">
        </select><br><br>
        <label for="jumlah_terjual">Jumlah Terjual:</label>
        <input type="text" id="jumlah_terjual" name="jumlah_terjual"><br><br>
        <label for="tanggal_transaksi">Tanggal Transaksi:</label>
        <input type="date" id="tanggal_transaksi" name="tanggal_transaksi"><br><br>
        <button type="submit" id="submitBtn">Tambah</button>
      </form>
    </div>
  </div>
  
  <div id="editTransactionPopup" class="popup">
    <div class="popup-content">
      <span class="close-btn" onclick="closeEditForm()">X</span>
      <h2>Edit Data Transaksi</h2>
      <form id="editTransactionForm">
        <input type="hidden" id="editTransactionId" name="transactionId">
        <label for="editBarangId">Nama Barang:</label>
        <select id="editBarangId" name="barang_id">
        </select><br><br>
        <label for="editJumlahTerjual">Jumlah Terjual:</label>
        <input type="text" id="editJumlahTerjual" name="jumlah_terjual"><br><br>
        <label for="editTanggalTransaksi">Tanggal Transaksi:</label>
        <input type="date" id="editTanggalTransaksi" name="tanggal_transaksi"><br><br>
        <button type="submit" id="editSubmitBtn">Simpan</button>
      </form>
    </div>
  </div>
    
  @include('footer')
    
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script>    
    function openAddForm() {
      document.getElementById('addTransactionPopup').style.display = 'block';
    }
    
    function closeAddForm() {
      document.getElementById('addTransactionPopup').style.display = 'none';
    }
    
    function openEditForm(id) {
      document.getElementById('editTransactionPopup').style.display = 'block';
      fetchTransactionById(id);
    }
    
    function closeEditForm() {
      document.getElementById('editTransactionPopup').style.display = 'none';
    }
    
    function submitForm(event) {
      event.preventDefault();
      const form = event.target;
      const formData = new FormData(form);

      axios.post('http://localhost:8000/api/transaksis/store', formData)
        .then(response => {
          console.log('Transaction added:', response.data);
          closeAddForm();
          fetchTransactions();
        })
        .catch(error => {
          console.error('Error adding transaction:', error);
        });
    }
    
    function fetchTransactionById(id) {
      axios.get(`http://localhost:8000/api/transaksis/${id}`)
        .then(response => {
          const transaction = response.data;
          document.getElementById('editTransactionId').value = transaction.id;
          document.getElementById('editBarangId').value = transaction.barang_id;
          document.getElementById('editJumlahTerjual').value = transaction.jumlah_terjual;
          document.getElementById('editTanggalTransaksi').value = transaction.tanggal_transaksi;
        })
        .catch(error => {
          console.error('Error fetching transaction by ID:', error);
        });
    }
    
    function submitEditForm(event) {
      event.preventDefault();
      const form = event.target;
      const formData = new FormData(form);
      const transactionId = formData.get('transactionId');

      axios.post(`http://localhost:8000/api/transaksis/edit/${transactionId}`, formData)
        .then(response => {
          console.log('Transaction updated:', response.data);
          closeEditForm();
          fetchTransactions();
        })
        .catch(error => {
          console.error('Error updating transaction:', error);
        });
    }
    
    function deleteTransaction(id) {
      axios.delete(`http://localhost:8000/api/transaksis/${id}`)
        .then(response => {
          console.log('Transaction deleted:', response.data);
          fetchTransactions();
        })
        .catch(error => {
          console.error('Error deleting transaction:', error);
        });
    }
    axios.get('http://localhost:8000/api/barangs')
    .then(response => {
      const barangs = response.data;
      const barangDropdown = document.getElementById('barang_id');
      barangs.forEach(barang => {       
        const option = document.createElement('option');
        option.value = barang.id; 
        option.textContent = barang.nama_barang; 
        barangDropdown.appendChild(option);
      });
    })
    .catch(error => {
      console.error('Error fetching barang data:', error);
    });
    axios.get('http://localhost:8000/api/barangs')
    .then(response => {
      const barangs = response.data;
      const editBarangDropdown = document.getElementById('editBarangId');
      barangs.forEach(barang => {
       
        const option = document.createElement('option');
        option.value = barang.id; 
        option.textContent = barang.nama_barang; 
        editBarangDropdown.appendChild(option);
      });
    })
    .catch(error => {
      console.error('Error fetching barang data for edit form:', error);
    });
    function fetchTransactions() {
      axios.get('http://localhost:8000/api/transaksis')
        .then(response => {
          const transactions = response.data;
          const tableBody = document.getElementById('transaksiTableBody');
          tableBody.innerHTML = '';
          transactions.forEach(transaction => {            
            axios.get(`http://localhost:8000/api/barangs/${transaction.barang_id}`)
              .then(barangResponse => {
                const barang = barangResponse.data;
                const row = `<tr>
                               <td>${count++}</td>
                              <td>${barang.nama_barang}</td> 
                              <td>${barang.stok}</td> 
                              <td>${transaction.jumlah_terjual}</td>
                              <td>${transaction.tanggal_transaksi}</td>
                              <td>${transaction.jenis_barang}</td>
                              <td>
                               <button class="edit-btn" onclick="openEditForm(${transaction.id})">Edit</button>
                               <button class="delete-btn" onclick="deleteTransaction(${transaction.id})">Delete</button>
                              </td>
                            </tr>`;
                tableBody.innerHTML += row;
              })
              .catch(error => {
                console.error('Error fetching barang details:', error);
              });
          });
        })
        .catch(error => {
          console.error('Error fetching transactions:', error);
        });
    }

    
    function fetchTransactions() {
        axios.get('http://localhost:8000/api/transaksis')
            .then(response => {
                const transactions = response.data;
                const tableBody = document.getElementById('transaksiTableBody');
                tableBody.innerHTML = '';
                let count = 1; 
                transactions.forEach(transaction => {            
                    axios.get(`http://localhost:8000/api/barangs/${transaction.barang_id}`)
                        .then(barangResponse => {
                            const barang = barangResponse.data;
                            const row = `<tr>
                                <td>${count++}</td>
                                <td>${barang.nama_barang}</td> 
                                <td>${barang.stok}</td> 
                                <td>${transaction.jumlah_terjual}</td>
                                <td>${transaction.tanggal_transaksi}</td>
                                <td>${transaction.jenis_barang}</td>
                                <td>
                                    <button class="edit-btn" onclick="openEditForm(${transaction.id})">Edit</button>
                                    <button class="delete-btn" onclick="deleteTransaction(${transaction.id})">Delete</button>
                                </td>
                            </tr>`;
                            tableBody.innerHTML += row;
                        })
                        .catch(error => {
                            console.error('Error fetching barang details:', error);
                        });
                });
            })
            .catch(error => {
                console.error('Error fetching transactions:', error);
            });
    }
function searchAndSort(order) {
    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date').value;

    axios.post('http://localhost:8000/api/transaksisb/search', { order: order, start_date: startDate, end_date: endDate })
        .then(response => {
            const transactions = response.data.data;
            const tableBody = document.getElementById('transaksiTableBody');
            tableBody.innerHTML = '';
            transactions.forEach(transaction => {
                axios.get(`http://localhost:8000/api/barangs/${transaction.barang_id}`)
                    .then(barangResponse => {
                        const barang = barangResponse.data;
                        const row = `<tr>
                             <td>${count++}</td>
                                <td>${barang.nama_barang}</td> 
                                <td>${barang.stok}</td> 
                                <td>${transaction.jumlah_terjual}</td>
                                <td>${transaction.tanggal_transaksi}</td>
                                <td>${transaction.jenis_barang}</td>
                              <td>
                                <button onclick="openEditForm(${transaction.id})">Edit</button>
                                <button onclick="deleteTransaction(${transaction.id})">Delete</button>
                              </td>
                            </tr>`;
                        tableBody.innerHTML += row;
                    })
                    .catch(error => {
                        console.error('Error fetching barang details:', error);
                    });
            });
        })
        .catch(error => {
            console.error('Error searching and sorting transactions:', error);
        });
}
    fetchTransactions();
    
    
    document.getElementById('transactionForm').addEventListener('submit', submitForm);
    document.getElementById('editTransactionForm').addEventListener('submit', submitEditForm);
  </script>
</body>
</html>
