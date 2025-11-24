                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

                    

                    <div class="row">
                        <div class="col-lg-6">
                            <?= form_error('menu', '<div class="alert-danger" role="alert">', '</div>'); ?>

                            <?=  $this->session->flashdata('message'); ?>

                        <a href=""class="btn btn-primary" data-toggle="modal"
                        data-target="#newMenuModal">Add New Menu</a>


                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Menu</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($menu as $m) : ?>
                                        <tr>
                                            <th scope="row"><?= $no++; ?></th>
                                            <td><?= $m['menu']; ?></td>
                                            <td>
                                                <a href="" class="badge badge-success">edit</a>
                                                <a href=""class="badge badge-danger">delete</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>



                        </div>
  
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
<!-- modal -->

<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="newMenuModal" tabindex="-1" role="dialog" aria-labelledby="newMenuModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      
      <!-- Form membungkus header, body, footer -->
      <form action="<?= base_url('menu');  ?>" method="post">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h5 class="modal-title" id="newMenuModalLabel">Add New Menu</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        
        <!-- Modal Body -->
        <div class="modal-body">
          <div class="form-group">
            <label for="menu">Menu Name</label>
            <input type="text" class="form-control" id="menu" name="menu" placeholder="Enter menu name">
          </div>
        </div>

        <!-- Modal Footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Add</button>
        </div>

      </form>
      
    </div>
  </div>
</div>

<!-- Pastikan JS Bootstrap & jQuery sudah terload -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>




 