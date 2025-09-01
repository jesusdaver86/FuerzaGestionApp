<aside class="main-sidebar">

	 <section class="sidebar">

		<ul class="sidebar-menu">

		<?php

		if($_SESSION["perfil"] == "Administrador"){

			echo '<li class="active">

				<a href="index.php?ruta=inicio">

					<i class="fa fa-home"></i>
					<span>Inicio</span>

				</a>

			</li>

			<li>

				<a href="index.php?ruta=usuarios">

					<i class="fa fa-user"></i>
					<span>Usuarios</span>

				</a>

			</li>';

		}

		if($_SESSION["perfil"] == "Administrador"){

			echo '<li class="active">

				<a href="index.php?ruta=trabajadores">

					<i class="fa fa-users"></i>
					<span>Trabajadores</span>

				</a>

			</li>

			<li>';

		}

		if($_SESSION["perfil"] == "Administrador"){

			echo '<li class="active">

				<a href="vistas/img/elFinder.html">

					<i class="fa fa-doc"></i>
					<span>Directorio</span>

				</a>

			</li>

			<li>';

		}

		if($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Especial"){

			echo '<li>

				<a href="index.php?ruta=operadores">

					<i class="fa fa-cog"></i>
					<span>Operadores</span>

				</a>

			</li>






			<li>

				<a href="index.php?ruta=marcas">

					<i class="fa fa-th"></i>
					<span>Marcas</span>

				</a>

			</li>






<li class="treeview">

				<a href="#">

					<i class="fa fa-road"></i>

					<span>Itinerarios</span>

					<span class="pull-right-container">

						<i class="fa fa-angle-left pull-right"></i>

					</span>

				</a>

				<ul class="treeview-menu">

					<li>

						<a href="index.php?ruta=origenes">

							<i class="fa fa-circle-o"></i>
							<span>Administrar origenes</span>

						</a>

					</li>

					<li>

						<a href="index.php?ruta=destinos">

							<i class="fa fa-circle-o"></i>
							<span>Administrar destinos</span>

						</a>

					</li>

					</ul>
					</li>










































			<li>

				<a href="index.php?ruta=unidades">

					<i class="fa fa-bus"></i>
					<span>Flota</span>

				</a>

			</li>


			<li>

				<a href="index.php?ruta=pasajeros">

					<i class="fa fa-users"></i>
					<span>Pasajeros</span>

				</a>

			</li>'

			;

		}



		/*

		if($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Vendedor"){

			echo '<li>

				<a href="index.php?ruta=pasajeros">

					<i class="fa fa-users"></i>
					<span>Pasajeros</span>

				</a>

			</li>';

		}

		if($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Vendedor"){

			echo '<li class="treeview">

				<a href="#">

					<i class="fa fa-list-ul"></i>

					<span>Despachos</span>

					<span class="pull-right-container">

						<i class="fa fa-angle-left pull-right"></i>

					</span>

				</a>

				<ul class="treeview-menu">

					<li>

						<a href="index.php?ruta=ventas">

							<i class="fa fa-circle-o"></i>
							<span>Administrar despachos</span>

						</a>

					</li>

					<li>

						<a href="index.php?ruta=crear-venta">

							<i class="fa fa-circle-o"></i>
							<span>Crear despacho</span>

						</a>

					</li>';

					if($_SESSION["perfil"] == "Administrador"){

					echo '<li>

						<a href="index.php?ruta=reportes">

							<i class="fa fa-circle-o"></i>
							<span>Reporte de despachos</span>

						</a>

					</li>
					<li>

						<a href="index.php?ruta=reportesp">

							<i class="fa fa-circle-o"></i>
							<span>Reporte de unidades</span>

						</a>

					</li>
					';

					}



				echo '</ul>

			</li>';

		}  */

		?>

		</ul>

	 </section>

</aside>
