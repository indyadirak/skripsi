<?php
include 'connection.php';
session_start();
if(!isset($_SESSION["login"]))
{
    header("location: index.php");
	exit;
}

$username=$_SESSION['login'];
$query = ' SELECT COUNT(*) as nomor FROM kerentanan';
$stmt = $conn->prepare($query);
$stmt->execute();
$number = $stmt->get_result();
$number = $number->fetch_assoc();
$query = 'SELECT kerentanan.nomor, kerentanan.kerentanan, perangkat.ip, kerentanan.kemungkinan, kerentanan.dampak, kerentanan.risiko FROM perangkat INNER JOIN kerentanan ON perangkat.nomor = kerentanan.ip;';
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

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

					<class="sidebar-item">
						<a class="sidebar-link" href="/menambahkan_perangkat.php">
              <i class="align-middle" data-feather="map"></i> <span class="align-middle">menambah perangkat</span>
            </a>
					</li>
					<li class="sidebar-header">
						kerentanan
					</li>

					<li class="sidebar-item active">
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

					<li class="sidebar-item">
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

					<h1 class="h3 mb-3">Vulnerability Dashboard</h1>
					<h5 class="card-title mb-0">menampilkan informasi seputar kerentanan yang telah ditemukan dari sistem kerentanan</h5>
					<br>

					<div class="row">
						<div class="col-12">
							<div class="card">
								<br>
								<div class="card-header position-absolute top-0 end-0"><a href="./menambahkan_kerentanan.php" class="btn btn-primary position-absolute top-50 end-0 translate-middle-y">Tambah kerentanan</a>
								<br>								</div>
								<br>
								<br>
								<div class="card-body">
								<class="mb-3">

									<div class="table-responsive">
										<table class="table table-striped table-hover">
											<thead>
												<tr>
													<th scope="col">No</th>
													<th scope="col">kerentanan</th>
													<th scope="col">IP Address</th>
													<th scope="col">kemungkinan</th>
													<th scope="col">dampak</th>
													<th scope="col">risiko</th>
													<th scope="col">status kerentanan</th>
													<th scope="col">aksi</th>
												</tr>
											</thead>
											<form action="hapus.php" method="post">
												<tbody>
													<form action="hapus.php" method="post">
													<input type="hidden" name="menu" value="2">
													<?php 
													
													$number = 1;
													while($row = $result->fetch_assoc()) 
													{

														echo '<tr>';
														echo '<td>'.$number.'</td>';
														echo '<td>'.$row['kerentanan'].'</td>';
														echo '<td>'.$row['ip'].'</td>';
														echo '<td>'.$row['kemungkinan'].'</td>';
														echo '<td>'.$row['dampak'].'</td>';
														echo '<td>'.$row['risiko'].'</td>';
														if($row['risiko'] >= 80)
														{
															echo '<td>'."tinggi".'</td>';
														}
														else if($row['risiko'] >= 21)
														{
															echo '<td>'."sedang".'</td>';
														}
														else
														{
															echo '<td>'."rendah".'</td>';
														}
														echo '<td><button type="submit" name="id" value="'.$row['nomor'].'" class="btn btn-danger"><i class="align-middle me-2" data-feather="trash-2"></i>Delete</button></td>';
														echo '</tr>';
														$number+=1;
													}
														?>
														</form>
												</tbody>
											</form>
										</table>	
									</div>
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