<?php echo $header ?>
<div class="container">
    <div class="row">
        <div class="list-wrapper">
            <div class="action-wrapper">
                <div class="link-wrapper">
                    <a href="<?php echo App\Vendor\Link::getLink('index', 'create') ?>">Add film</a>
                </div>
            </div>
            <form method="post"
                  action="<?= \App\Vendor\Link::getLink() ?>">
                <div class="list-wrapper__search">
                    <div class="form-group">
                        <input type="text" name="search_name" placeholder="Search name"
                               value="<?php if (!is_null($request->search_name)) echo $request->search_name;echo ''; ?>"
                               id="search_name">
                    </div>
                    <div class="form-group">
                        <input type="text" name="search_actor" placeholder="Search actor"
                               value="<?php if (!is_null($request->search_name)) echo $request->search_actor;echo ''; ?>"
                               id="search_actor">
                    </div>
                    <div class="action-wrapper">
                        <input type="submit" value="Find">
                    </div>
                </div>
                <div class="clear"></div>
            </form>
            <?php if (!empty($films)) { ?>
                <table class="list-wrapper__table">
                    <thead>
                    <tr>
                        <?php $order = (is_null($request->order) || $request->order == 'desc') ? 'asc' : 'desc'; ?>

                        <td>
                            <a href="<?= \App\Vendor\Link::getLink('index', 'index', ['sort' => 'id', 'order' => $order]) ?>">Id</a>
                        </td>
                        <td>
                            <a href="<?= \App\Vendor\Link::getLink('index', 'index', ['sort' => 'name', 'order' => $order]) ?>">Name</a>
                        </td>
                        <td>
                            <a href="<?= \App\Vendor\Link::getLink('index', 'index', ['sort' => 'year', 'order' => $order]) ?>">Year</a>
                        </td>
                        <td>Show</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($films as $film) { ?>
                        <tr>
                            <td><?php echo $film['id'] ?></td>
                            <td><?php echo $film['name'] ?></td>
                            <td><?php echo $film['year'] ?></td>
                            <td>
                                <div class="link-wrapper">
                                    <a href="<?php echo App\Vendor\Link::getLink('index', 'edit', ['id' => $film['id']]) ?>">Edit</a>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <div class="list-wrapper__empty">There are no films yet.</div>
            <?php } ?>
            <div class="list-wrapper__file">
                <form action="<?= \App\Vendor\Link::getLink('parser') ?>"
                      method="post"
                      enctype="multipart/form-data">

                    <div class="action-wrapper">
                        <input type="file" name="films" id="file">
                        <input type="submit" value="Load">
                    </div>
                    <?php if ($errors->hasError('films')) { ?>
                        <div class="error">
                            <?= $errors->getFirstError('films') ?>
                        </div>
                    <?php } ?>
                </form>
            </div>
        </div>
    </div>
</div>
<?php echo $footer ?>
