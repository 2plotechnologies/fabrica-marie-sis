<section class="full-width container-notifications">
		<div class="full-width container-notifications-bg btn-Notification"></div>
	    <section class="NotificationArea">
			<div class="full-width text-center NotificationArea-title tittles">
				Notificaciones de Pagos Vencidos <i class="zmdi zmdi-close btn-Notification"></i>
			</div>

			<?php
			require 'backend/conexion.php';
			$hoy = new DateTime();

			$stmt = $pdo->prepare("
				SELECT co.*, c.NombreCliente 
				FROM cobranzas co
				INNER JOIN ventas v ON co.Id_Venta = v.Id
				INNER JOIN clientes c ON v.Id_Cliente = c.Id
				WHERE co.pagado = 0 AND co.fecha_pago < CURDATE()
				ORDER BY co.fecha_pago ASC
			");
			$stmt->execute();

			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$fecha = (new DateTime($row['fecha_pago']))->format('d-m-Y');
				$monto = number_format($row['monto_cuota'], 2);
				echo '
				<a href="cobranzas.php" class="Notification">
					<div class="Notification-icon">
						<i class="zmdi zmdi-alert-circle bg-danger"></i>
					</div>
					<div class="Notification-text">
						<p>
							<i class="zmdi zmdi-circle"></i>
							<strong>Pago vencido - '.$row['NombreCliente'].'</strong><br>
							<small>Cuota '.$row['Numero_Cuota'].' | S/'.$monto.' | Venció el '.$fecha.'</small>
						</p>
					</div>
				</a>';
			}
			?>
		</section>

	</section>