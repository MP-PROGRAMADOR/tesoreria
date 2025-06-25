<?php
// trabajar aqui ahora
require "../componentes/head.php";
$codEntrada = $_GET['id'];
?>
<div class="container-scroller">

  <!-- partial:partials/_navbar.html -->
  <?php require "../componentes/topMenu.php"; ?>
  <!-- partial -->
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
    <?php require "../componentes/sidebarUser.php"; ?> 
    <!-- partial -->
    <div class="main-panel">
      <div class="content-wrapper">
        <div class="row">
          <div class="col-sm-12">
            <div class="home-tab">
              <?php
              $qEntrada = "SELECT * FROM entradas WHERE entradas.Id = '$codEntrada'";
              $resulEntrada = mysqli_query($conn, $qEntrada);
              $Entrada = mysqli_fetch_array($resulEntrada);
              ?>
              <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                <div>
                  <div class="btn-wrapper">
                    <!-- <a href="#" class="btn btn-otline-dark"><i class="icon-printer"></i> Imprimir</a> -->
                  </div>
                </div>
              </div>
              <?php
              $qDecreto = "SELECT decretos.Descripcion, decretos.Fecha, decretos.Archivo FROM decretos INNER JOIN entradas ON decretos.DocEntrada = entradas.Id WHERE entradas.Id = '$codEntrada'";
              $resul = mysqli_query($conn, $qDecreto);
              $numDecre = mysqli_num_rows($resul);

              $qDestino = "SELECT destino.Miembro FROM destino INNER JOIN decretos ON destino.Decreto = decretos.Id WHERE decretos.DocEntrada ='$codEntrada' GROUP BY(destino.Miembro)";
              $resulDes = mysqli_query($conn, $qDestino);
              $numDest = mysqli_num_rows($resulDes);
              ?>
              <div class="tab-content tab-content-basic">
                <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="statistics-details d-flex align-items-center justify-content-between">
                        <div>
                          <p class="statistics-title">Nº de Registro:</p>
                          <h3 class="rate-percentage"><?php echo  $Entrada['NumRegistro'];; ?></h3>
                        </div>
                        <div>
                          <p class="statistics-title">Fecha de Registro</p>
                          <h3 class="rate-percentage"><?php echo  $Entrada['FechaRegistro']; ?></h3>
                        </div>
                        <div>
                          <p class="statistics-title">Importe</p>
                          <h3 class="rate-percentage"><?php echo  $Entrada['Importe']; ?> XAF</h3>
                        </div>
                        <div class="d-none d-md-block">
                          <p class="statistics-title">Nº Decretos</p>
                          <h3 class="rate-percentage"><?php echo  $numDecre; ?></h3>
                        </div>
                        <div class="d-none d-md-block">
                          <p class="statistics-title">Nº Destinos</p>
                          <h3 class="rate-percentage"><?php echo  $numDest; ?></h3>
                        </div>
                        <div class="d-none d-md-block">
                          <p class="statistics-title">Referencia</p>
                          <?php
                          $codeRefe = $Entrada['Referencia'];
                          $qRef = "SELECT * FROM referencias WHERE Id = '$codeRefe'";
                          $resulRef = mysqli_query($conn, $qRef);
                          $ref = mysqli_fetch_array($resulRef);
                          ?>
                          <h3 class="rate-percentage"><?php echo  $ref['Codigo']; ?></h3>
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
                              <?php
                              $qUsuario = "SELECT usuarios.Nombre FROM usuarios INNER JOIN entradas ON entradas.Usuario = usuarios.Id WHERE entradas.Id = '$codEntrada'";
                              $resulUsuario = mysqli_query($conn, $qUsuario);
                              $Usuario = mysqli_fetch_array($resulUsuario);

                              $qInstitucion = "SELECT departementos.Nombre, departementos.Institucion, proviene.Seccion 
                                FROM departementos INNER JOIN proviene ON departementos.Id = proviene.Seccion WHERE proviene.Entrada ='$codEntrada'";
                              $resulInsti = mysqli_query($conn, $qInstitucion);
                              $datoInst = mysqli_fetch_array($resulInsti);
                              $filas = mysqli_num_rows($resulInsti);
                              ?>
                              <div class="d-sm-flex justify-content-between align-items-start">
                                <div class="TopDetallEntradaP">
                                  <div class="TopDetallEntrada">
                                    <h4 class="card-title card-title-dash">Entrada realizado por: <?php echo  $Usuario['Nombre']; ?></h4>
                                    <p class="card-subtitle card-subtitle-dash">Tipo de Documento: <strong><?php echo  $Entrada['TipoDoc']; ?></strong> </p>
                                    <a title="Descargar archivo" class="btn btn-primary me-2" href="../documentos/entradas/<?= $Entrada['Archivo']; ?>" download="Entrada-<?= $Entrada['NumRegistro']; ?>"><i class="mdi mdi-download"></i></a>
                                  </div>

                                </div>
                                <div>

                                </div>
                              </div>

                              <div class="chartjs-bar-wrapper mt-3">
                                <h5><strong>Descripción del documento</strong></h5>
                                <p class="card-subtitle card-subtitle-dash"><?php echo  $Entrada['Descripcion']; ?></p>
                              </div>
                              <div class="TopDetallEntrada">
                                <?php
                                if ($filas == 0) {
                                  $qPF = "SELECT personafisica.NombreCompleto FROM personafisica INNER JOIN entradas ON personafisica.Entrada = entradas.Id WHERE entradas.Id = '$codEntrada'";
                                  $resulPF = mysqli_query($conn, $qPF);
                                  $DatoPF = mysqli_fetch_array($resulPF);

                                ?>

                                  <h4 class="card-title card-title-dash">Procedencia: <?php echo  $DatoPF['NombreCompleto']; ?></h4>
                                <?php   } else {

                                  $codeInst = $datoInst['Institucion'];
                                  $qInt = "SELECT * FROM instituciones WHERE Id = '$codeInst'";
                                  $resulInst = mysqli_query($conn, $qInt);
                                  $instiNom = mysqli_fetch_array($resulInst);

                                ?>

                                  <h4 class="card-title card-title-dash">Procedencia: <?php echo  $instiNom['Nombre'] . "/" . $instiNom['Nombre_Corto']; ?></h4>

                                <?php }  ?>

                                <h4 class="card-title card-title-dash">F. Firma: <?php echo  $Entrada['FechaFirma']; ?></h4>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- fin del cuadro de entradas -->
                      <div class="row flex-grow">
                        <div class="col-12 grid-margin stretch-card">
                          <div class="card card-rounded">
                            <div class="card-body">
                              <?php
                              $qDecreto = "SELECT decretos.Descripcion, decretos.Fecha, decretos.Archivo FROM decretos INNER JOIN entradas ON decretos.DocEntrada = entradas.Id WHERE entradas.Id = '$codEntrada'";
                              $resul = mysqli_query($conn, $qDecreto);
                              $numDecre = mysqli_num_rows($resul);
                              ?>
                              <div class="d-sm-flex justify-content-between align-items-start">
                                <div>
                                  <h4 class="card-title card-title-dash">Decretos de la entrada</h4>
                                  <p class="card-subtitle card-subtitle-dash">Esta entrada tiene <?php echo  $numDecre; ?> decretos</p>
                                </div>

                              </div>
                              <div class="table-responsive  mt-1">
                                <table class="table select-table">
                                  <thead>
                                    <tr>                                      
                                      <th>Descripcion</th>
                                      <th>Fecha</th>
                                      <th>Archivo</th>

                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                    while ($FilasDecretos = mysqli_fetch_array($resul)) {
                                    ?>
                                      <tr>
                                        
                                        <td>
                                          <p><?php echo $FilasDecretos['Descripcion']; ?></p>
                                        </td>
                                        <td>
                                          <p><?php echo $FilasDecretos['Fecha']; ?></p>
                                        </td>
                                        <td>
                                          <div class="d-flex ">
                                            <a class="btn btn-primary me-2" href="../documentos/decretos/<?= $FilasDecretos['Archivo']; ?>" download="Decreto-Entrada-<?= $FilasDecretos['Archivo']; ?>"><i class="mdi mdi-file"></i></a>
                                            <div>
                                              <h6><?php echo $FilasDecretos['Archivo']; ?></h6>
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
                      <!-- fin de  los decretos -->

                    </div>
                    <div class="col-lg-4 d-flex flex-column">
                      <div class="row flex-grow">
                        <div class="col-12 grid-margin stretch-card">
                          <div class="card card-rounded">
                            <div class="card-body">
                              <div class="row">
                                <div class="col-lg-12">
                                  <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="card-title card-title-dash">Miembros intervenidos</h4>
                                    <div class="add-items d-flex mb-0">
                                      <!-- <input type="text" class="form-control todo-list-input" placeholder="What do you need to do today?"> -->
                                      <!-- <button class="add btn btn-icons btn-rounded btn-primary todo-list-add-btn text-white me-0 pl-12p"><i class="mdi mdi-plus"></i></button> -->

                                    </div>
                                  </div>
                                  <div class="list-wrapper">
                                    <?php
                                    $qIdMiembro = "SELECT destino.Miembro FROM destino INNER JOIN decretos ON destino.Decreto = decretos.Id WHERE decretos.DocEntrada ='$codEntrada' GROUP BY(destino.Miembro)";
                                    $resulId = mysqli_query($conn, $qIdMiembro);
                                    $numDecre = mysqli_num_rows($resulId);
                                    ?>
                                    <ul class="todo-list todo-list-rounded">
                                      <?php
                                      while ($FilasMiembros = mysqli_fetch_array($resulId)) {
                                        $codMiem = $FilasMiembros['Miembro'];
                                        $qMiem = "SELECT * FROM miembros WHERE Id = '$codMiem'";
                                        $ResultMiem = mysqli_query($conn, $qMiem);
                                      ?>

                                        <li class="d-block">
                                          <div class="form-check w-100">

                                            <div class="d-flex mt-2">
                                              <?php while ($FilasMiembro = mysqli_fetch_array($ResultMiem)) {
                                                # code...
                                              ?>
                                              <div class="ps-4 text-small me-3"><?php echo $FilasMiembro['Nombre']; ?></div>
                                              <?php } ?>

                                            </div>
                                          </div>
                                        </li>
                                      <?php } ?>

                                    </ul>
                                    <h4 class="card-title card-title-dash">Personas Físicas intervenidos</h4>
                                    <?php
                                    $qIdMiembro = "SELECT personafisica.NombreCompleto FROM personafisica INNER JOIN decretos ON personafisica.Decreto = decretos.Id WHERE decretos.DocEntrada ='$codEntrada' GROUP BY(personafisica.NombreCompleto )";
                                    $resulId = mysqli_query($conn, $qIdMiembro);
                                    $numDecre = mysqli_num_rows($resulId);
                                    ?>
                                    <ul class="todo-list todo-list-rounded">
                                      <?php
                                      while ($FilasMiembros = mysqli_fetch_array($resulId)) {
                                       
                                      ?>
                                        <li class="d-block">
                                          <div class="form-check w-100">

                                            <div class="d-flex mt-2">
                                             
                                              <div class="ps-4 text-small me-3"><?php echo $FilasMiembros['NombreCompleto']; ?></div>                                              

                                            </div>
                                          </div>
                                        </li>
                                      <?php } ?>

                                    </ul>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>


                      <div class="row flex-grow">

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