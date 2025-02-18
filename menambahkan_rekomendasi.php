<?php
include 'connection.php';
session_start();
if (!isset($_SESSION["login"])) {
    header("location: index.php");
    exit;
}

$username = $_SESSION['login'];

// Ambil daftar IP dari database
$query = "SELECT ip FROM perangkat";
$stmt = $conn->prepare($query);
$stmt->execute();
$ip_proses = $stmt->get_result();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) 
{
    // Ambil nomor perangkat baru
    $query = "SELECT COUNT(*) as nomor FROM kerentanan";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    $nomor = ($result->num_rows > 0) ? $result->fetch_assoc()['nomor'] + 1 : 1;
    
    // Ambil data dari form
    $judul = $_POST['judul'];
    $ip = $_POST['ip'];
    $kemungkinan = $_POST['kemungkinan'];
    $dampak = $_POST['dampak'];

    //proses risiko
    $risiko = $kemungkinan * $dampak;
    

        // Simpan data baru
        $query = "INSERT INTO kerentanan VALUES ('$nomor', '$judul', '$ip', '$kemungkinan', '$dampak', '$risiko')";
        $stmt = $conn->prepare($query);
        if ($stmt->execute()) {
            echo "<script>alert('Data berhasil dditambahkan!');</script>";
        } else {
            echo "<script>alert('Terjadi kesalahan!');</script>";
        }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="img/icons/icon-48x48.png" />

	<link rel="canonical" href="https://demo-basic.adminkit.io/" />

	<title>Dashboard Perangkat Sistem Manajemen Risiko</title>

	<link href="./dashboard.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
	<div class="wrapper">
		<nav id="sidebar" class="sidebar js-sidebar">
			<div class="sidebar-content js-simplebar">
				<a class="sidebar-brand" href="index.html">
          <span class="align-middle">Risk management system</span>
        </a>

				<ul class="sidebar-nav">
					<li class="sidebar-header">
						halaman
					</li>

					<li class="sidebar-item ">
						<a class="sidebar-link" href="./dashboard.php">
              <i class="align-middle" data-feather="home"></i> <span class="align-middle">Dashboard Utama</span>
            </a>
					</li>

					<li class="sidebar-header">
						perangkat
					</li>

			        </a>
					<li class="sidebar-item">
						<a class="sidebar-link" href="./dashboard_perangkat.php">
              <i class="align-middle" data-feather="airplay"></i> <span class="align-middle">dashboard perangkat</span>
            </a>
					</li>

					<li class="sidebar-item">
						<a class="sidebar-link" href="./menambahkan_perangkat.php">
              <i class="align-middle" data-feather="map"></i> <span class="align-middle">menambah perangkat</span>
            </a>
					</li>
					<li class="sidebar-header">
						kerentanan
					</li>

					<li class="sidebar-item">
						<a class="sidebar-link" href="./dashboard_kerentanan.php">
              <i class="align-middle" data-feather="bar-chart-2"></i> <span class="align-middle">dashboard kerentanan</span>
            </a>
					</li>

					<li class="sidebar-item">
						<a class="sidebar-link" href="./menambahkan_kerentanan.php">
              <i class="align-middle" data-feather="map"></i> <span class="align-middle">menambah kerentanan</span>
            </a>
					</li>
					</a>

					</li>
					<li class="sidebar-header">
						rekomendasi
					</li>

					<li class="sidebar-item">
						<a class="sidebar-link" href="./dashboard_rekomendasi.php">
              <i class="align-middle" data-feather="bar-chart-2"></i> <span class="align-middle">dashboard rekomendasi</span>
            </a>
					</li>

					<li class="sidebar-item active">
						<a class="sidebar-link" href="./menambahkan_rekomendasi.php">
              <i class="align-middle" data-feather="map"></i> <span class="align-middle">menambah rekomendasi</span>
            </a>
					</li>
				</ul>

			</div>
		</nav>

		<div class="main">
			<nav class="navbar navbar-expand navbar-light navbar-bg">
				<a class="sidebar-toggle js-sidebar-toggle">
          <i class="hamburger align-self-center"></i>
        </a>

				<div class="navbar-collapse collapse">
					<ul class="navbar-nav navbar-align">
						<li class="nav-item dropdown">
							<a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                <i class="align-middle" data-feather="settings"></i>
              </a>

							<a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                <img src="img/avatars/avatar.jpg" class="avatar img-fluid rounded me-1" alt="Charles Hall" /> <span class="text-dark"><?php
				printf("%s", $username);
				?>
				</span>
              </a>
							<div class="dropdown-menu dropdown-menu-end">
<!-- 								<a class="dropdown-item" href="pages-profile.html"><i class="align-middle me-1" data-feather="user"></i> Profile</a>
								<a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="pie-chart"></i> Analytics</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="index.html"><i class="align-middle me-1" data-feather="settings"></i> Settings & Privacy</a>
								<a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="help-circle"></i> Help Center</a>
								<div class="dropdown-divider"></div> -->
								<a class="dropdown-item" href="logout.php">Log out</a>
							</div>
						</li>
					</ul>
				</div>
			</nav>

			<main class="content">
				<div class="container-fluid p-0">

					<div class="container-fluid p-0">

					<h1 class="h3 mb-3">Halaman menambah kerentanan</h1>
					<div class="card-header">
						<h5 class="card-title mb-0">pada halaman ini kita akan menambah kerentanan yang telah ditemukan ataupun dimiliki dari aplikasi kerentanan</h5>
					</div>
					<br>
					<div class="row">
						<div class="col-12">
							<div class="card">
								<form action="./menambahkan_kerentanan.php" method="post">										
                                    <div class="card-body">
										<div class="card-header">
											<h5 class="card-title mb-0">1. judul kerentanan</h5>
										</div>
										<div class="card-body">
											<input type="text" name="judul" class="form-control"  placeholder="Input">
										</div>
										<div class="card-header">
											<h5 class="card-title mb-0">2. Ip Address</h5>
										</div>
										<div class="card-body">
                                            <select name="ip" class="form-select mb-3" required>
                                            <option selected>Open this select menu</option>
                                                <?php while ($row = $ip_proses->fetch_assoc()): ?>
                                                    <option value="<?php echo $row['ip']; ?>"><?php echo $row['ip']; ?></option>
                                                <?php endwhile; ?>
                                            </select><br>
										</div>
										<div class="card-header">
											<h5 class="card-title mb-0">3. kemungkinan kerentanan</h5>
										</div>
										<div class="card-body">
											<input type="number" step="any" name="kemungkinan"class="form-control"  placeholder="Input">
										</div>
										<div class="card-header">
											<h5 class="card-title mb-0">4. dampak kerentanan</h5>
										</div>
										<div class="card-body">
											<input type="number"  name="dampak" class="form-control"   placeholder="Input">
										</div>
										<br>
										<br>
										<br>
										<div class="input_box button position-absolute bottom-0 end-0">
											<input type="submit" class="btn btn-primary" value="submit" name="submit">
										</div>
								</form>
							</div>
						</div>
					</div>

				</div>

				</div>
			</main>

			<footer class="footer">
				<div class="container-fluid">
					<div class="row text-muted">
						<div class="col-6 text-start">
							<p class="mb-0">
								<a class="text-muted" href="https://adminkit.io/" target="_blank"><strong>AdminKit</strong></a> - <a class="text-muted" href="https://adminkit.io/" target="_blank"><strong>Bootstrap Admin Template</strong></a>								&copy;
							</p>
						</div>
					</div>
				</div>
			</footer>
		</div>
	</div>

	<script src="js/app.js"></script>	

</body>

</html>