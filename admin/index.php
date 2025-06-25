<?php

include '../conexion/conexion.php';
// cogiendo el numero de entradas
$sql_entradas = "SELECT * FROM entradas";
$resultado_entradas = mysqli_query($conn, $sql_entradas);
$numero_entradas = mysqli_num_rows($resultado_entradas);

// cogiendo el numero de Salidas
$sql_salidas = "SELECT * FROM salidas";
$resultado_salidas = mysqli_query($conn, $sql_salidas);
$numero_salidas = mysqli_num_rows($resultado_salidas);

// cogiendo el numero de REFERENCIAS
$sql_Referencias = "SELECT * FROM referencias";
$resultado_referencia = mysqli_query($conn, $sql_Referencias);
$numero_referencia = mysqli_num_rows($resultado_referencia);

// cogiendo el numero de DECRETOS
$sql_decreto = "SELECT * FROM decretos";
$resultado_decreto = mysqli_query($conn, $sql_decreto);
$numero_decretos = mysqli_num_rows($resultado_decreto);

// cogiendo el numero de DESTINOS
$sql_destinos = "SELECT * FROM destino";
$resultado_destinos = mysqli_query($conn, $sql_destinos);
$numero_destinos = mysqli_num_rows($resultado_destinos);

// cogiendo el numero de INSTITUCIONES
$sql_instituciones = "SELECT * FROM instituciones";
$resultado_instituciones = mysqli_query($conn, $sql_instituciones);
$numero_instituciones = mysqli_num_rows($resultado_instituciones);

?>



<?php require "../componentes/head.php"; ?>
<!-- fin del header -->






<div class="container-scroller">

  <!-- partial:partials/_navbar.html inicio del top menu -->
  <?php require "../componentes/topMenu.php"; ?>

  <!-- partial fin del top menu -->
  <div class="container-fluid page-body-wrapper">
    <!-- partial:partials/_settings-panel.html -->
    <div class="theme-setting-wrapper">
      <div id="settings-trigger"><i class="ti-settings"></i></div>
      <div id="theme-settings" class="settings-panel">
        <i class="settings-close ti-close"></i>
        <p class="settings-heading">SIDEBAR SKINS</p>
        <div class="sidebar-bg-options selected" id="sidebar-light-theme">
          <div class="img-ss rounded-circle bg-light border me-3"></div>Light
        </div>
        <div class="sidebar-bg-options" id="sidebar-dark-theme">
          <div class="img-ss rounded-circle bg-dark border me-3"></div>Dark
        </div>
        <p class="settings-heading mt-2">HEADER SKINS</p>
        <div class="color-tiles mx-0 px-4">
          <div class="tiles success"></div>
          <div class="tiles warning"></div>
          <div class="tiles danger"></div>
          <div class="tiles info"></div>
          <div class="tiles dark"></div>
          <div class="tiles default"></div>
        </div>
      </div>
    </div>
    <div id="right-sidebar" class="settings-panel">
      <i class="settings-close ti-close"></i>
      <ul class="nav nav-tabs border-top" id="setting-panel" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" id="todo-tab" data-bs-toggle="tab" href="#todo-section" role="tab" aria-controls="todo-section" aria-expanded="true">TO DO LIST</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="chats-tab" data-bs-toggle="tab" href="#chats-section" role="tab" aria-controls="chats-section">CHATS</a>
        </li>
      </ul>
      <div class="tab-content" id="setting-content">
        <div class="tab-pane fade show active scroll-wrapper" id="todo-section" role="tabpanel" aria-labelledby="todo-section">
          <div class="add-items d-flex px-3 mb-0">
            <form class="form w-100">
              <div class="form-group d-flex">
                <input type="text" class="form-control todo-list-input" placeholder="Add To-do">
                <button type="submit" class="add btn btn-primary todo-list-add-btn" id="add-task">Add</button>
              </div>
            </form>
          </div>
          <div class="list-wrapper px-3">
            <ul class="d-flex flex-column-reverse todo-list">
              <li>
                <div class="form-check">
                  <label class="form-check-label">
                    <input class="checkbox" type="checkbox">
                    Team review meeting at 3.00 PM
                  </label>
                </div>
                <i class="remove ti-close"></i>
              </li>
              <li>
                <div class="form-check">
                  <label class="form-check-label">
                    <input class="checkbox" type="checkbox">
                    Prepare for presentation
                  </label>
                </div>
                <i class="remove ti-close"></i>
              </li>
              <li>
                <div class="form-check">
                  <label class="form-check-label">
                    <input class="checkbox" type="checkbox">
                    Resolve all the low priority tickets due today
                  </label>
                </div>
                <i class="remove ti-close"></i>
              </li>
              <li class="completed">
                <div class="form-check">
                  <label class="form-check-label">
                    <input class="checkbox" type="checkbox" checked>
                    Schedule meeting for next week
                  </label>
                </div>
                <i class="remove ti-close"></i>
              </li>
              <li class="completed">
                <div class="form-check">
                  <label class="form-check-label">
                    <input class="checkbox" type="checkbox" checked>
                    Project review
                  </label>
                </div>
                <i class="remove ti-close"></i>
              </li>
            </ul>
          </div>
          <h4 class="px-3 text-muted mt-5 fw-light mb-0">Events</h4>
          <div class="events pt-4 px-3">
            <div class="wrapper d-flex mb-2">
              <i class="ti-control-record text-primary me-2"></i>
              <span>Feb 11 2018</span>
            </div>
            <p class="mb-0 font-weight-thin text-gray">Creating component page build a js</p>
            <p class="text-gray mb-0">The total number of sessions</p>
          </div>
          <div class="events pt-4 px-3">
            <div class="wrapper d-flex mb-2">
              <i class="ti-control-record text-primary me-2"></i>
              <span>Feb 7 2018</span>
            </div>
            <p class="mb-0 font-weight-thin text-gray">Meeting with Alisa</p>
            <p class="text-gray mb-0 ">Call Sarah Graves</p>
          </div>
        </div>
        <!-- To do section tab ends -->
        <div class="tab-pane fade" id="chats-section" role="tabpanel" aria-labelledby="chats-section">
          <div class="d-flex align-items-center justify-content-between border-bottom">
            <p class="settings-heading border-top-0 mb-3 pl-3 pt-0 border-bottom-0 pb-0">Friends</p>
            <small class="settings-heading border-top-0 mb-3 pt-0 border-bottom-0 pb-0 pr-3 fw-normal">See All</small>
          </div>
          <ul class="chat-list">
            <li class="list active">
              <div class="profile"><img src="images/faces/face1.jpg" alt="image"><span class="online"></span></div>
              <div class="info">
                <p>Thomas Douglas</p>
                <p>Available</p>
              </div>
              <small class="text-muted my-auto">19 min</small>
            </li>
            <li class="list">
              <div class="profile"><img src="images/faces/face2.jpg" alt="image"><span class="offline"></span></div>
              <div class="info">
                <div class="wrapper d-flex">
                  <p>Catherine</p>
                </div>
                <p>Away</p>
              </div>
              <div class="badge badge-success badge-pill my-auto mx-2">4</div>
              <small class="text-muted my-auto">23 min</small>
            </li>
            <li class="list">
              <div class="profile"><img src="images/faces/face3.jpg" alt="image"><span class="online"></span></div>
              <div class="info">
                <p>Daniel Russell</p>
                <p>Available</p>
              </div>
              <small class="text-muted my-auto">14 min</small>
            </li>
            <li class="list">
              <div class="profile"><img src="images/faces/face4.jpg" alt="image"><span class="offline"></span></div>
              <div class="info">
                <p>James Richardson</p>
                <p>Away</p>
              </div>
              <small class="text-muted my-auto">2 min</small>
            </li>
            <li class="list">
              <div class="profile"><img src="images/faces/face5.jpg" alt="image"><span class="online"></span></div>
              <div class="info">
                <p>Madeline Kennedy</p>
                <p>Available</p>
              </div>
              <small class="text-muted my-auto">5 min</small>
            </li>
            <li class="list">
              <div class="profile"><img src="images/faces/face6.jpg" alt="image"><span class="online"></span></div>
              <div class="info">
                <p>Sarah Graves</p>
                <p>Available</p>
              </div>
              <small class="text-muted my-auto">47 min</small>
            </li>
          </ul>
        </div>
        <!-- chat tab ends -->
      </div>
    </div>
    <!-- partial -->
    <!-- partial:partials/_sidebar.html -->
    <?php require "../componentes/sidebarAdmin.php"; ?>
    <!-- partial fin del sidebar-->
    <div class="main-panel">
      <div class="content-wrapper">
        <div class="row">
          <div class="col-sm-12">
            <div class="home-tab">
              <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                <ul class="nav nav-tabs" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active ps-0" id="home-tab" data-bs-toggle="tab" href="index.php" role="tab" aria-controls="overview" aria-selected="true">Inicio</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="usuarios.php" role="tab" aria-selected="false">Usuarios</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="contact-tab" data-bs-toggle="tab" href="miembros.php" role="tab" aria-selected="false">Miembros</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link border-0" id="more-tab" data-bs-toggle="tab" href="departamentos.php" role="tab" aria-selected="false">Departamentos</a>
                  </li>
                </ul>
                <div>
                  <div class="btn-wrapper">
                    <a href="#" class="btn btn-otline-dark"><i class="icon-printer"></i> Imprimir</a>
                  </div>
                </div>
              </div>
              <div class="tab-content tab-content-basic">
                <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="statistics-details d-flex align-items-center justify-content-between">
                        <div>
                          <p class="statistics-title">ENTRADAS</p>
                          <h3 class="rate-percentage"><?php echo $numero_entradas;    ?></h3>

                        </div>
                        <div>
                          <p class="statistics-title">SALIDAD</p>
                          <h3 class="rate-percentage"><?php echo $numero_salidas;    ?></h3>

                        </div>
                        <div>
                          <p class="statistics-title">REFERENCIAS</p>
                          <h3 class="rate-percentage"> <?php echo $numero_referencia;    ?></h3>

                        </div>
                        <div class="d-none d-md-block">
                          <p class="statistics-title">DECRETOS</p>
                          <h3 class="rate-percentage"><?php echo $numero_decretos;    ?></h3>

                        </div>
                        <div class="d-none d-md-block">
                          <p class="statistics-title">DESTINOS</p>
                          <h3 class="rate-percentage"><?php echo $numero_destinos;    ?></h3>

                        </div>
                        <div class="d-none d-md-block">
                          <p class="statistics-title">INSTITUCIONES</p>
                          <h3 class="rate-percentage"><?php echo $numero_instituciones;    ?></h3>

                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-8 d-flex flex-column">
                      <div class="row flex-grow">
                        <div class="col-12 grid-margin stretch-card">
                          <div class="card card-rounded">
                            <div class="card-body">
                              <div class="d-sm-flex justify-content-between align-items-start">
                                <div>
                                  <h4 class="card-title card-title-dash">Estadisticas</h4>
                                  <p class="card-subtitle card-subtitle-dash">estadistica del registro de entrada y salidas</p>
                                </div>

                              </div>
                              <div class="d-sm-flex align-items-center mt-1 justify-content-between">
                                <div class="d-sm-flex align-items-center mt-4 justify-content-between">
                                  <!-- <h4 class="text-success">(+1.37%)</h4> -->
                                </div>
                                <div class="me-3">
                                  <div id="marketing-overview-legend"></div>
                                </div>
                              </div>
                              <div class="chartjs-bar-wrapper mt-3">
                                <!-- <canvas id="marketingOverview"></canvas> -->

                                <div id="columnchart_material" style="width: 100%; height: 300px;"></div>

                              </div>
                            </div>
                          </div>
                        </div>
                      </div>



                      <div class="row flex-grow">
                        <div class="col-12 grid-margin stretch-card">
                          <div class="card card-rounded">
                            <div class="card-body">
                              <div class="d-sm-flex justify-content-between align-items-start">
                                <div>
                                  <h4 class="card-title card-title-dash">Progreso de Usuario</h4>

                                </div>

                              </div>
                              <div class="table-responsive  mt-1">
                                <table class="table select-table">
                                  <thead>
                                    <tr>
                                      <th>USUARIO</th>
                                      <th>DEPARTAMENTO</th>
                                      <th>ENTRADAS</th>
                                      <th>SALIDAS</th>
                                    </tr>
                                  </thead>
                                  <tbody>



                                    <?php

                                    include '../conexion/conexion.php';

                                    $sql_usuario = "SELECT * FROM usuarios";
                                    $resultado_usuario = mysqli_query($conn, $sql_usuario);


                                    while ($row_usuarios = $resultado_usuario->fetch_assoc()) {

                                    ?>

                                      <tr>
                                        <td>
                                          <div class="d-flex">
                                            <img src="data:image/*;base64,<?php echo base64_encode($row_usuarios['Foto']); ?>" alt="" height="50px">
                                            <div>
                                              <h6><?= $row_usuarios['Nombre'];   ?></h6>
                                              <p><?= $row_usuarios['Tipo_Usuario'];   ?></p>
                                            </div>
                                          </div>
                                        </td>
                                        <td>
                                          <h6></h6>
                                          <?php
                                          $codeDep = $row_usuarios['Dpto'];
                                          $depart = "SELECT * FROM departementos WHERE Id = '$codeDep'";
                                          $resulDep = mysqli_query($conn, $depart);
                                          $nomDep = mysqli_fetch_array($resulDep);
                                          ?>
                                          <p><?= $nomDep['Nombre'];  ?></p>
                                        </td>
                                        <td>
                                          <?php
                                          $user_id = $row_usuarios['Id'];
                                          $sql_entradaUser = "SELECT * FROM entradas WHERE Usuario = $user_id";
                                          $resultado_entradaUser = mysqli_query($conn, $sql_entradaUser);
                                          $numero_entrada = mysqli_num_rows($resultado_entradaUser);
                                          ?>
                                          <div>
                                            <?php
                                            $resulDivE = ($numero_entrada / $numero_entradas) * 100;
                                            $porCientoEntrada = round($resulDivE);
                                            ?>
                                            <div class="d-flex justify-content-between align-items-center mb-1 max-width-progress-wrap">
                                              <p class="text-success"><?php echo $porCientoEntrada; ?>%</p>
                                              <p><?php echo $numero_entrada . "/" . $numero_entradas; ?></p>
                                            </div>
                                            <div class="progress progress-md">
                                              <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $resulDivE; ?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                          </div>
                                        </td>
                                        <td>
                                          <?php
                                          $users_id = $row_usuarios['Id'];
                                          $sql_salida = "SELECT * FROM salidas where Usuario=$users_id";
                                          $resultado_salida = mysqli_query($conn, $sql_salida);
                                          $numero_salida = mysqli_num_rows($resultado_salida);
                                          ?>
                                          <div>
                                            <?php
                                            $resulDivS = ($numero_salida / $numero_salidas) * 100;
                                            $porCientoSalida = round($resulDivS);
                                            ?>
                                            <div class="d-flex justify-content-between align-items-center mb-1 max-width-progress-wrap">
                                              <p class="text-danger"><?php echo $porCientoSalida; ?>%</p>
                                              <p><?php echo $numero_salida . "/" . $numero_salidas; ?></p>
                                            </div>
                                            <div class="progress progress-md">
                                              <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo $resulDivS; ?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                          </div>
                                        </td>
                                      </tr>


                                    <?php } ?>



                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>


                    </div>
                    <div class="col-lg-4 d-flex flex-column">
                      <div class="row flex-grow">
                        <div class="col-12 grid-margin stretch-card">
                          <div class="card card-rounded">
                            <div class="card-body">
                              <div class="row">
                                <div class="col-lg-12">
                                  <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="card-title card-title-dash">Ultimos registros de Entrada</h4>
                                    <div class="add-items d-flex mb-0">
                                      <!-- <input type="text" class="form-control todo-list-input" placeholder="What do you need to do today?"> -->
                                      <button class="add btn btn-icons btn-rounded btn-primary todo-list-add-btn text-white me-0 pl-12p"><i class="mdi mdi-plus"></i></button>
                                    </div>
                                  </div>
                                  <div class="list-wrapper">
                                    <ul class="todo-list todo-list-rounded">
                                      <li class="d-block">

                                        <!-- cogiendo todos los registros de entrada -->
                                        <?php

                                        $sql_entradas2 = "SELECT * FROM entradas ORDER BY Id DESC LIMIT 4";
                                        $resultado_entradas = mysqli_query($conn, $sql_entradas2);
                                        $fila = mysqli_fetch_assoc($resultado_entradas);



                                        ?>

                                        <div class="form-check w-100">
                                          <label class="form-check-label">
                                            <input class="checkbox" type="checkbox"><?php echo $fila['Descripcion'];  ?><i class="input-helper rounded"></i>
                                          </label>
                                          <div class="d-flex mt-2">
                                            <div class="ps-4 text-small me-3"><?php echo $fila['FechaRegistro'];  ?></div>
                                            <div class="badge badge-opacity-warning me-3">Numero: <?php echo $fila['NumRegistro'];  ?></div>
                                            <i class="mdi mdi-flag ms-2 flag-color"></i>
                                          </div>


                                        </div>
                                      </li>

                                    </ul>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="row flex-grow">
                        <div class="col-12 grid-margin stretch-card">
                          <div class="card card-rounded">
                            <div class="card-body">
                              <div class="row">
                                <div class="col-lg-12">
                                  <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                      <h4 class="card-title card-title-dash">Ultimos registros de salida</h4>
                                    </div>
                                  </div>
                                  <div class="mt-3">


                                    <!-- cogiendo todos los registros de entrada -->
                                    <?php

                                    $sql_salida23 = "SELECT * FROM salidas ORDER BY Id DESC LIMIT 4";
                                    $resultado_salida23 = mysqli_query($conn, $sql_salida23);
                                    $fila2 = mysqli_fetch_assoc($resultado_salida23);

                                    $numero = mysqli_num_rows($resultado_salida23);

                                    ?>


                                    <div class="form-check w-100">
                                      <label class="form-check-label">
                                        <input class="checkbox" type="checkbox"><?php echo $fila2['Descripcion'];  ?><i class="input-helper rounded"></i>
                                      </label>
                                      <div class="d-flex mt-2">
                                        <div class="ps-4 text-small me-3"><?php echo $fila2['FechaRegistro'];  ?></div>
                                        <div class="badge badge-opacity-warning me-3">Numero: <?php echo $fila2['NumRegistro'];  ?></div>
                                        <i class="mdi mdi-flag ms-2 flag-color"></i>
                                      </div>


                                    </div>


                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
      <!-- partial:partials/_footer.html -->
      <?php require "../componentes/footer.php"; ?>