
		<!-- Left panel : Navigation area -->
		<aside id="left-panel">
			<!-- User info -->
			<div class="login-info">
				<span> <!-- User image size is adjusted inside CSS, it should stay as it --> 
					
					<a href="javascript:void(0);" id="user-shortcut" style="pointer-events: none; cursor: default; color: #fff;">
						<i class="fa fa-user-circle fa-2x text-success"></i> 
						&nbsp;&nbsp;
						<span style="margin-top: -10px">
							<?= $_SESSION['name'] . " " . $_SESSION['lastname']; ?>
						</span>
					</a> 
					
				</span>
			</div>
			<!-- end user info -->
			
			<nav>

				<ul>
			
					<li <?php if($page == 'dashboard') { echo 'class="active"'; } ?>>
						<a href="<?= base_url() ?>" title="Escritorio"><i class="fa fa-lg fa-fw fa-home"></i> <span class="menu-item-parent">Escritorio</span></a>
					</li>

					<?php if(in_array($_SESSION['profile'], array(1))) { ?>
					
					<li <?php if($page == 'clientes') { echo 'class="active"'; } ?>>
						<a href="<?= base_url() ?>clientes"><i class="fa fa-lg fa-fw fa-briefcase"></i> <span class="menu-item-parent">Clientes</span></a>
					</li>
					<?php } ?>

					<?php if(in_array($_SESSION['profile'], array(1,2,3))) { ?>
					<li>
						<a href="#"><i class="fa fa-lg fa-fw fa-shopping-cart"></i> <span class="menu-item-parent">Proveedores</span></a>
						<ul>
							<li <?php if($page == 'suppliers') { echo 'class="active"'; } ?>>
								<a href="<?= base_url() ?>proveedores">Proveedores</a>
							</li>
							<li <?php if($page == 'shambles') { echo 'class="active"'; } ?>>
								<a href="<?= base_url() ?>frigorificos">Frigoríficos</a>
							</li>
						</ul>						
					</li>
					<?php } ?>

					<?php if(in_array($_SESSION['profile'],array(1,2,3,4))) { ?>
					<li>
						<a href="#"><i class="fa fa-lg fa-fw fa-line-chart"></i> <span class="menu-item-parent">Finanzas</span></a>
						<ul>
							<?php if(in_array($_SESSION['profile'],array(1,2,3))) { ?>
							<li>
								<a href="#"><span class="menu-item-parent">Trans. Proveedores</span></a>
								<ul>
									<li <?php if($page == 'fin_adv_suppliers') { echo 'class="active"'; } ?>>
										<a href="<?= base_url() ?>finanzas/anticipos_proveedores">Anticipos</a>
									</li>
									<li <?php if($page == 'fin_cash_suppliers') { echo 'class="active"'; } ?>>
										<a href="<?= base_url() ?>finanzas/decontado_proveedores">De contado</a>
									</li>
									<li <?php if($page == 'fin_credit_suppliers') { echo 'class="active"'; } ?>>
										<a href="<?= base_url() ?>finanzas/credito_proveedores">Crédito</a>
									</li>
									<li <?php if($page == 'fin_adv_suppliers_archived') { echo 'class="active"'; } ?>>
										<a href="<?= base_url() ?>finanzas/transacciones_proveedores_archivados">Archivados</a>
									</li>
								</ul>
							</li>
							<?php } ?>

							<?php if(in_array($_SESSION['profile'], array(1))) { ?>
							<li>
								<a href="#"><span class="menu-item-parent">Anticipos de Clientes</span></a>
								<ul>
									<li <?php if($page == 'fin_adv_clients') { echo 'class="active"'; } ?>>
										<a href="<?= base_url() ?>finanzas/anticipos_clientes">Activos</a>
									</li>
									<li <?php if($page == 'fin_adv_clients_archived') { echo 'class="active"'; } ?>>
										<a href="<?= base_url() ?>finanzas/anticipos_clientes_archivados">Archivados</a>
									</li>
								</ul>
							</li>
							<?php } ?>
							<?php if(in_array($_SESSION['profile'],array(1,2,3,4))) { ?>
							<li <?php if($page == 'outgoes') { echo 'class="active"'; } ?>>
								<a href="<?= base_url() ?>gastos">Gastos Regionales</a>
							</li>
							<?php } ?>
							<?php if(in_array($_SESSION['profile'],array(1,2))) { ?>
							<li <?php if($page == 'outgoes_generals') { echo 'class="active"'; } ?>>
								<a href="<?= base_url() ?>gastos/generales">Gastos Generales</a>
							</li>
							<?php } ?>
							<?php if(in_array($_SESSION['profile'],array(1,2))) { ?>
							<li <?php if($page == 'outgoes_types') { echo 'class="active"'; } ?>>
								<a href="<?= base_url() ?>gastos/tipos">Tipos de Gastos</a>
							</li>
							<?php } ?>

							<li <?php if($page == 'outgoes_img_support') { echo 'class="active"'; } ?>>
								<a href="<?= base_url() ?>gastos/soporte_gastos">Soportes de Gastos</a>
							</li>
						</ul>
					</li>
					<?php } ?>
					<?php if(in_array($_SESSION['profile'],array(1,2,3,4))) { ?>
					<li>
						<a href="#"><i class="fa fa-lg fa-fw fa-archive"></i> <span class="menu-item-parent">Bodega</span></a>
						<ul>
							<?php if(in_array($_SESSION['profile'],array(1,2,3,4))) { ?>
							<li <?php if($page == 'storage_receptions') { echo 'class="active"'; } ?>>
								<a href="<?= base_url() ?>bodega/recepciones">Recepciones</a>
							</li>
							<li <?php if($page == 'storage_dispatches_regional') { echo 'class="active"'; } ?>>
								<a href="<?= base_url() ?>bodega/despachos_regionales">Despachos Regionales</a>
							</li>
							<?php } ?>

							<?php if(in_array($_SESSION['profile'],array(1,2,3,4)) && $_SESSION['regional'] == 1 ) { ?>
							<li <?php if($page == 'storage_dispatches_client') { echo 'class="active"'; } ?>>
								<a href="<?= base_url() ?>bodega/despachos_clientes">Despachos a Clientes</a>
							</li>
							<li <?php if($page == 'storage_receptions_central') { echo 'class="active"'; } ?>>
								<a href="<?= base_url() ?>bodega/recepciones_central">Recepciones Central</a>
							</li>
							<?php } ?>

							<?php if(in_array($_SESSION['profile'],array(1,2))) { ?>
							<li <?php if($page == 'storage_products') { echo 'class="active"'; } ?>>
								<a href="<?= base_url() ?>bodega/productos">Productos</a>
							</li>
							<?php } ?>

							<li <?php if($page == 'storage_reception_img_support') { echo 'class="active"'; } ?>>
								<a href="<?= base_url() ?>bodega/soporte_recepciones">Soportes de Recepciones</a>
							</li>
						</ul>
					</li>
					<?php } ?>
					<li>
						<a href="#"><i class="fa fa-lg fa-fw fa-building"></i> <span class="menu-item-parent">Regional</span></a>
						<ul>
							<?php if(in_array($_SESSION['profile'], array(1,2))) { ?>
							<li <?php if($page == 'regionals') { echo 'class="active"'; } ?>>
								<a href="<?= base_url() ?>regionales">Ver/Editar</a>
							</li>
							<?php } ?>
							<li <?php if($page == 'regional_rrhh') { echo 'class="active"'; } ?>>
								<a href="<?= base_url() ?>regionales/recursos_humanos">Recursos Humanos</a>
							</li>
						</ul>
					</li>

					<?php if(in_array($_SESSION['profile'], array(1,2,3,4))) { ?>
					<li>
						<a href="#"><i class="fa fa-lg fa-fw fa-cogs"></i> <span class="menu-item-parent">Sistema</span></a>
						<ul>
							<?php if(in_array($_SESSION['profile'], array(1))) { ?>
							<li>
								<a href="#"><span class="menu-item-parent">Usuarios</span></a>
								<ul>
									<li <?php if($page == 'users') { echo 'class="active"'; } ?>>
										<a href="<?= base_url() ?>usuarios">Ver/Editar</a>
									</li> 
									<li <?php if($page == 'users_alert') { echo 'class="active"'; } ?>>
										<a href="<?= base_url() ?>usuarios/alertas">Alertas del Sistema</a>
									</li>  
								</ul>
							</li> 
							
							<li>
								<a href="#"><span class="menu-item-parent">Lugares</span></a>
								<ul>
									<li <?php if($page == 'location_countries') { echo 'class="active"'; } ?>>
										<a href="<?= base_url() ?>lugares/paises">Países</a>
									</li> 
									<li <?php if($page == 'location_departments') { echo 'class="active"'; } ?>>
										<a href="<?= base_url() ?>lugares/departamentos">Departamentos</a>
									</li> 
									<li <?php if($page == 'location_cities') { echo 'class="active"'; } ?>>
										<a href="<?= base_url() ?>lugares/ciudades">Ciudades</a>
									</li> 
								</ul>
							</li>
							<?php } ?>
							<?php if(in_array($_SESSION['profile'], array(1,2,3,4))) { ?>
							<li>
								<a href="#"><span class="menu-item-parent">Reportes</span></a>
								<ul>
									<?php if(in_array($_SESSION['profile'], array(1))) { ?>
									<li <?php if($page == 'report_clients') { echo 'class="active"'; } ?>>
										<a href="<?= base_url() ?>reportes/clientes">Clientes</a>
									</li> 
									<li <?php if($page == 'report_departments') { echo 'class="active"'; } ?>>
										<a href="<?= base_url() ?>reportes/departamentos">Departamentos</a>
									</li>
									<?php } ?>
									<?php if(in_array($_SESSION['profile'], array(1,2,3,4))) { ?>
									<li <?php if($page == 'report_suppliers') { echo 'class="active"'; } ?>>
										<a href="<?= base_url() ?>reportes/proveedores">Proveedores</a>
									</li>
									<?php } ?>
									<?php if(in_array($_SESSION['profile'], array(1))) { ?>
									<li <?php if($page == 'report_finances') { echo 'class="active"'; } ?>>
										<a href="<?= base_url() ?>reportes/finanzas">Finanzas</a>
									</li>
									<li <?php if($page == 'report_storage') { echo 'class="active"'; } ?>>
										<a href="<?= base_url() ?>reportes/bodega">Bodega</a>
									</li>
									<?php } ?>
									<?php if(in_array($_SESSION['profile'], array(1,2,3))) { ?>
									<li <?php if($page == 'report_regionals') { echo 'class="active"'; } ?>>
										<a href="<?= base_url() ?>reportes/regionales">Regionales</a>
									</li> 
									<?php } ?>
								</ul>
							</li>
							<?php } ?>
						</ul>
					</li>
					<?php } ?>
					<li <?php if($page == 'user_update_pass') { echo 'class="active"'; } ?>>
						<a href="<?= base_url() ?>usuarios/cambiar_contrasena"><i class="fa fa-lg fa-fw fa-lock"></i> <span class="menu-item-parent">Cambiar contraseña</span></a>
					</li>
					<li <?php if($page == 'tutorial') { echo 'class="active"'; } ?>>
						<a href="<?= base_url() ?>tutorial"><i class="fa fa-lg fa-fw fa-film"></i> <span class="menu-item-parent">Tutorial</span></a>
					</li>
					
					
				</ul>
			</nav>
			<span class="minifyme" data-action="minifyMenu"> 
				<i class="fa fa-arrow-circle-left hit"></i> 
			</span>

		</aside>
		<!-- END NAVIGATION -->