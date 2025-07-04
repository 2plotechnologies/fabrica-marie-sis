<section class="full-width navLateral">
		<div class="full-width navLateral-bg btn-menu"></div>
		<div class="full-width navLateral-body">
			<div class="full-width navLateral-body-logo text-center tittles">
				<i class="zmdi zmdi-close btn-menu"></i> Sistema de Administración 
			</div>
			<figure class="full-width navLateral-body-tittle-menu">
				<div>
					<img src="assets/img/<?php echo $_SESSION["avatar"]; ?>" alt="Avatar" class="img-responsive">
				</div>
				<figcaption>
					<span>
						<?php echo $_SESSION["usuario"]; ?><br>
						<small><?php if($_SESSION["rol"] == '1'){echo "Admin";}else{echo "Vendedor";}  ?></small>
					</span>
				</figcaption>
			</figure>
			<nav class="full-width">
				<ul class="full-width list-unstyle menu-principal">
					<li class="full-width">
						<a href="home.php" class="full-width">
							<div class="navLateral-body-cl">
								<i class="zmdi zmdi-view-dashboard"></i>
							</div>
							<div class="navLateral-body-cr">
								Inicio
							</div>
						</a>
					</li>
					<li class="full-width divider-menu-h"></li>
					<li class="full-width">
						<a href="#!" class="full-width btn-subMenu">
							<div class="navLateral-body-cl">
								<i class="zmdi zmdi-case"></i>
							</div>
							<div class="navLateral-body-cr">
								Administración
							</div>
							<span class="zmdi zmdi-chevron-left"></span>
						</a>
						<ul class="full-width menu-principal sub-menu-options">
							<?php if($_SESSION["rol"] == 1){?>
							<li class="full-width">
								<a href="company.php" class="full-width">
									<div class="navLateral-body-cl">
										<i class="zmdi zmdi-globe"></i>
									</div>
									<div class="navLateral-body-cr">
										Regiones y distritos
									</div>
								</a>
							</li>
							<li class="full-width">
								<a href="providers.php" class="full-width">
									<div class="navLateral-body-cl">
										<i class="zmdi zmdi-truck"></i>
									</div>
									<div class="navLateral-body-cr">
										Proveedores
									</div>
								</a>
							</li>
							<?php } ?>
							<li class="full-width">
								<a href="payments.php" class="full-width">
									<div class="navLateral-body-cl">
										<i class="zmdi zmdi-card"></i>
									</div>
									<div class="navLateral-body-cr">
										Gastos
									</div>
								</a>
							</li>
							<?php if($_SESSION["rol"] == 1){?>
							<li class="full-width">
								<a href="categories.php" class="full-width">
									<div class="navLateral-body-cl">
										<i class="zmdi zmdi-label"></i>
									</div>
									<div class="navLateral-body-cr">
										Presentaciones
									</div> 
								</a>
							</li>
							<li class="full-width">
								<a href="promotions.php" class="full-width">
									<div class="navLateral-body-cl">
										<i class="zmdi zmdi-card-giftcard"></i>
									</div>
									<div class="navLateral-body-cr">
										Promociones
									</div>
								</a>
							</li>
							<?php } ?>
						</ul>
					</li>
					<?php if($_SESSION["rol"] == 1){?>
					<li class="full-width divider-menu-h"></li>
					<li class="full-width">
						<a href="#!" class="full-width btn-subMenu">
							<div class="navLateral-body-cl">
								<i class="zmdi zmdi-face"></i>
							</div>
							<div class="navLateral-body-cr">
								Usuarios
							</div>
							<span class="zmdi zmdi-chevron-left"></span>
						</a>
						<ul class="full-width menu-principal sub-menu-options">
							<li class="full-width">
								<a href="admin.php" class="full-width">
									<div class="navLateral-body-cl">
										<i class="zmdi zmdi-account"></i>
									</div>
									<div class="navLateral-body-cr">
										Crear y listar usuarios
									</div>
								</a>
							</li>
							<li class="full-width">
								<a href="client.php" class="full-width">
									<div class="navLateral-body-cl">
										<i class="zmdi zmdi-accounts"></i>
									</div>
									<div class="navLateral-body-cr">
										Clientes
									</div>
								</a>
							</li>
						</ul>
					</li>
					<?php } ?>
					<li class="full-width divider-menu-h"></li>
					<li class="full-width">
						<a href="products.php" class="full-width">
							<div class="navLateral-body-cl">
								<i class="zmdi zmdi-washing-machine"></i>
							</div>
							<div class="navLateral-body-cr">
								Productos
							</div>
						</a>
					</li>
					<li class="full-width divider-menu-h"></li>
					<li class="full-width">
						<a href="sales.php" class="full-width">
							<div class="navLateral-body-cl">
								<i class="zmdi zmdi-shopping-cart"></i>
							</div>
							<div class="navLateral-body-cr">
								Ventas
							</div>
						</a>
					</li>
					<li class="full-width">
						<a href="cobranzas.php" class="full-width">
							<div class="navLateral-body-cl">
								<i class="zmdi zmdi-money"></i>
							</div>
							<div class="navLateral-body-cr">
								Cobranzas
							</div>
						</a>
					</li>
					<li class="full-width divider-menu-h"></li>
					<!--
					<li class="full-width">
						<a href="inventory.php" class="full-width">
							<div class="navLateral-body-cl">
								<i class="zmdi zmdi-store"></i>
							</div>
							<div class="navLateral-body-cr">
								Inventario
							</div>
						</a>
					</li>
					-->
					<li class="full-width divider-menu-h"></li>
					<li class="full-width">
						<a href="#!" class="full-width btn-subMenu">
							<div class="navLateral-body-cl">
								<i class="zmdi zmdi-receipt"></i>
							</div>
							<div class="navLateral-body-cr">
								Reportes
							</div>
							<span class="zmdi zmdi-chevron-left"></span>
						</a>
						<ul class="full-width menu-principal sub-menu-options">
							<li class="full-width">
								<a href="reporte_ventas.php" class="full-width">
									<div class="navLateral-body-cl">
										<i class="zmdi zmdi-widgets"></i>
									</div>
									<div class="navLateral-body-cr">
										Reporte de Ventas
									</div>
								</a>
							</li>

							<li class="full-width">
								<a href="reporte_gastos.php" class="full-width">
									<div class="navLateral-body-cl">
										<i class="zmdi zmdi-widgets"></i>
									</div>
									<div class="navLateral-body-cr">
										Reporte de Gastos
									</div>
								</a>
							</li>
						</ul>
					</li>
				</ul>
			</nav>
		</div>
	</section>