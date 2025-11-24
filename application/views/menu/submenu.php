<!-- Begin Page Content -->
<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg">

            <?= $this->session->flashdata('message'); ?>

            <!-- Add New Submenu -->
            <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newSubMenuModal">
                Add New Submenu
            </a>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Menu</th>
                        <th>Url</th>
                        <th>Icon</th>
                        <th>Active</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; foreach($subMenu as $sm): ?>
                    <tr>
                        <th><?= $no++; ?></th>
                        <td><?= $sm['title']; ?></td>
                        <td><?= $sm['menu']; ?></td>
                        <td><?= $sm['url']; ?></td>
                        <td><?= $sm['icon']; ?></td>
                        <td><?= $sm['is_active'] ? 'Active' : 'Inactive'; ?></td>
                        <td>
                            <!-- EDIT -->
                            <a href="#" class="badge badge-success" data-toggle="modal" data-target="#editModal<?= $sm['id']; ?>">Edit</a>

                            <!-- DELETE -->
                            <a href="#" class="badge badge-danger" data-toggle="modal" data-target="#deleteModal<?= $sm['id']; ?>">Delete</a>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editModal<?= $sm['id']; ?>" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form action="<?= base_url('menu/editSubmenu/'.$sm['id']); ?>" method="post">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Submenu</h5>
                                        <button type="button" class="close" data-dismiss="modal">
                                            <span>&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <input type="text" name="title" class="form-control" value="<?= $sm['title']; ?>" placeholder="Submenu title">
                                        </div>
                                        <div class="form-group">
                                            <select name="menu_id" class="form-control">
                                                <?php foreach($menu as $m): ?>
                                                    <option value="<?= $m['id']; ?>" <?= $m['id']==$sm['menu_id']?'selected':''; ?>><?= $m['menu']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="url" class="form-control" value="<?= $sm['url']; ?>" placeholder="Submenu url">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="icon" class="form-control" value="<?= $sm['icon']; ?>" placeholder="Submenu icon">
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="is_active" value="1" <?= $sm['is_active']?'checked':''; ?>>
                                            <label class="form-check-label">Active?</label>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Delete Modal -->
                    <div class="modal fade" id="deleteModal<?= $sm['id']; ?>" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-danger text-white">
                                    <h5 class="modal-title">Delete Confirmation</h5>
                                    <button type="button" class="close text-white" data-dismiss="modal">
                                        <span>&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Apakah kamu yakin ingin menghapus submenu "<strong><?= $sm['title']; ?></strong>"?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <form action="<?= base_url('menu/deleteSubmenu/'.$sm['id']); ?>" method="post" style="display:inline;">
                                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </div>

</div>

<!-- Add New Submenu Modal -->
<div class="modal fade" id="newSubMenuModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?= base_url('menu/submenu'); ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Sub Menu</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" name="title" class="form-control" placeholder="Submenu title">
                    </div>
                    <div class="form-group">
                        <select name="menu_id" class="form-control">
                            <option value="">Select menu</option>
                            <?php foreach ($menu as $m): ?>
                                <option value="<?= $m['id']; ?>"><?= $m['menu']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" name="url" class="form-control" placeholder="Submenu url">
                    </div>
                    <div class="form-group">
                        <input type="text" name="icon" class="form-control" placeholder="Submenu icon">
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" checked>
                        <label class="form-check-label">Active?</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JS Bootstrap -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
