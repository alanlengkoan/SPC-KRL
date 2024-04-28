<!-- begin:: breadcumb -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="page-header-title">
                    <h4 class="m-b-10"><?= $title ?></h4>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.html">
                            <i class="feather icon-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#!">Dashboard</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- end:: breadcumb -->

<!-- begin:: content -->
<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <!-- begin:: card -->
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-6">
                                <h5 class="w-75 p-2">Basis</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-block table-border-style">
                        <table class="table table-striped table-bordered nowrap" style="width: 100%;">
                            <thead>
                                <tr align="center">
                                    <th>Contrast</th>
                                    <th>Correlation</th>
                                    <th>Energy</th>
                                    <th>Homogeneity</th>
                                    <th>Label</th>
                                    <th>Euclidian Distance</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $a = $ini->processEuclidianDistance($data_training, $data_test);

                                foreach ($a as $k_a => $v_a) { ?>
                                    <tr align="center">
                                        <td><?= $data_training[$k_a]->contrast ?></td>
                                        <td><?= $data_training[$k_a]->correlation ?></td>
                                        <td><?= $data_training[$k_a]->energy ?></td>
                                        <td><?= $data_training[$k_a]->homogeneity ?></td>
                                        <td><?= $data_training[$k_a]->nama ?></td>
                                        <td><?= $v_a ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-6">
                                <h5 class="w-75 p-2">Rangking</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-block table-border-style">
                        <table class="table table-striped table-bordered nowrap" style="width: 100%;">
                            <thead>
                                <tr align="center">
                                    <th>Contrast</th>
                                    <th>Correlation</th>
                                    <th>Energy</th>
                                    <th>Homogeneity</th>
                                    <th>Label</th>
                                    <th>Euclidian Distance</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $b = $ini->processMinToMaxEuclidianDistance($a);

                                foreach ($b as $k_b => $v_b) { ?>
                                    <tr align="center">
                                        <td><?= $data_training[$k_b]->contrast ?></td>
                                        <td><?= $data_training[$k_b]->correlation ?></td>
                                        <td><?= $data_training[$k_b]->energy ?></td>
                                        <td><?= $data_training[$k_b]->homogeneity ?></td>
                                        <td><?= $data_training[$k_b]->nama ?></td>
                                        <td><?= $v_b ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-6">
                                <h5 class="w-75 p-2">Nilai K = n</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-block table-border-style">
                        <table class="table table-striped table-bordered nowrap" style="width: 100%;">
                            <thead>
                                <tr align="center">
                                    <th>K = 1</th>
                                    <th>K = 3</th>
                                    <th>K = 5</th>
                                    <th>K = 7</th>
                                    <th>K = 9</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $k1 = $ini->processClasificationKToN($b, $data_training, 1);
                                $k3 = $ini->processClasificationKToN($b, $data_training, 3);
                                $k5 = $ini->processClasificationKToN($b, $data_training, 5);
                                $k7 = $ini->processClasificationKToN($b, $data_training, 7);
                                $k9 = $ini->processClasificationKToN($b, $data_training, 9);

                                for ($i = 0; $i < count($data_training); $i++) { ?>
                                    <tr align="center">
                                        <td><?= $k1[$i] ?></td>
                                        <td><?= $k3[$i] ?></td>
                                        <td><?= $k5[$i] ?></td>
                                        <td><?= $k7[$i] ?></td>
                                        <td><?= $k9[$i] ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-6">
                                <h5 class="w-75 p-2">Konsultasi</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-block table-border-style">
                        <table class="table table-striped table-bordered" style="width: 100%;">
                            <thead>
                                <tr align="center">
                                    <th>Contrast</th>
                                    <th>Correlation</th>
                                    <th>Energy</th>
                                    <th>Homogeneity</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr align="center">
                                    <td><?= $data_test['contrast'] ?></td>
                                    <td><?= $data_test['correlation'] ?></td>
                                    <td><?= $data_test['energy'] ?></td>
                                    <td><?= $data_test['homogeneity'] ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-6">
                                <h5 class="w-75 p-2">Hasil Konsultasi</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-block table-border-style">
                        <table class="table table-striped table-bordered" style="width: 100%;">
                            <thead>
                                <tr align="center">
                                    <th>K1</th>
                                    <th>K3</th>
                                    <th>K5</th>
                                    <th>K7</th>
                                    <th>K9</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $r1 = $ini->processClasification($k1, $data_classification);
                                $r3 = $ini->processClasification($k3, $data_classification);
                                $r5 = $ini->processClasification($k5, $data_classification);
                                $r7 = $ini->processClasification($k7, $data_classification);
                                $r9 = $ini->processClasification($k9, $data_classification);

                                $this->db->update(
                                    'tb_consultation',
                                    [
                                        'id_classification' => $r3['id'],
                                    ],
                                    [
                                        'id_consultation' => $id_consultation
                                    ]
                                );
                                ?>
                                <tr align="center">
                                    <td><?= $r1['label'] ?></td>
                                    <td><?= $r3['label'] ?></td>
                                    <td><?= $r5['label'] ?></td>
                                    <td><?= $r7['label'] ?></td>
                                    <td><?= $r9['label'] ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <a class="btn btn-primary" data-toggle="collapse" href="#cardOne" role="button" aria-expanded="false" aria-controls="cardOne">
                            Validitas K3
                        </a>
                        &nbsp;
                        <a class="btn btn-primary" data-toggle="collapse" href="#cardTwo" role="button" aria-expanded="false" aria-controls="cardTwo">
                            Weight Voting
                        </a>
                        &nbsp;
                        <a class="btn btn-primary" data-toggle="collapse" href="#cardThree" role="button" aria-expanded="false" aria-controls="cardThree">
                            Result
                        </a>
                    </div>
                    <div class="collapse" id="cardOne">
                        <div class="card-block table-border-style">
                            <table class="table table-striped table-bordered nowrap" id="tabel-rangking" style="width: 100%;">
                                <thead>
                                    <tr align="center">
                                        <th>Contrast</th>
                                        <th>Correlation</th>
                                        <th>Energy</th>
                                        <th>Homogeneity</th>
                                        <th>Klasifikasi</th>
                                        <th>Validitas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $e = $ini->processValiditasKToN($b, $data_training, $r3['label'], 3);

                                    foreach ($e as $k_e => $v_e) { ?>
                                        <tr align="center">
                                            <td><?= $data_training[$k_e]->contrast ?></td>
                                            <td><?= $data_training[$k_e]->correlation ?></td>
                                            <td><?= $data_training[$k_e]->energy ?></td>
                                            <td><?= $data_training[$k_e]->homogeneity ?></td>
                                            <td><?= $data_training[$k_e]->nama ?></td>
                                            <td><?= $v_e ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="collapse" id="cardTwo">
                        <div class="card-block table-border-style">
                            <table class="table table-striped table-bordered nowrap" id="tabel-rangking" style="width: 100%;">
                                <thead>
                                    <tr align="center">
                                        <th>Contrast</th>
                                        <th>Correlation</th>
                                        <th>Energy</th>
                                        <th>Homogeneity</th>
                                        <th>Klasifikasi</th>
                                        <th>Weight Voting</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $f = $ini->processWeightVoting($b, $e);

                                    foreach ($f as $k_f => $v_f) { ?>
                                        <tr align="center">
                                            <td><?= $data_training[$k_f]->contrast ?></td>
                                            <td><?= $data_training[$k_f]->correlation ?></td>
                                            <td><?= $data_training[$k_f]->energy ?></td>
                                            <td><?= $data_training[$k_f]->homogeneity ?></td>
                                            <td><?= $data_training[$k_f]->nama ?></td>
                                            <td><?= $v_f['weight'] ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="collapse" id="cardThree">
                        <div class="card-block table-border-style">
                            <table class="table table-striped table-bordered nowrap" id="tabel-rangking" style="width: 100%;">
                                <thead>
                                    <tr align="center">
                                        <th>Contrast</th>
                                        <th>Correlation</th>
                                        <th>Energy</th>
                                        <th>Homogeneity</th>
                                        <th>Klasifikasi</th>
                                        <th>Euclidian Distance</th>
                                        <th>Validitas</th>
                                        <th>Weight Voting</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $f = $ini->processWeightVoting($b, $e);

                                    foreach ($f as $k_f => $v_f) { ?>
                                        <tr align="center">
                                            <td><?= $data_training[$k_f]->contrast ?></td>
                                            <td><?= $data_training[$k_f]->correlation ?></td>
                                            <td><?= $data_training[$k_f]->energy ?></td>
                                            <td><?= $data_training[$k_f]->homogeneity ?></td>
                                            <td><?= $data_training[$k_f]->nama ?></td>
                                            <td><?= $v_f['euclidian'] ?></td>
                                            <td><?= $v_f['validitas'] ?></td>
                                            <td><?= $v_f['weight'] ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- end:: card -->
            </div>
        </div>
    </div>
</div>
<!-- end:: content -->