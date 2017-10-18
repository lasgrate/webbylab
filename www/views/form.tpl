<?= $header ?>
<div class="container">
    <div class="row">
        <div class="create-wrapper">
            <form action="<?= \App\Vendor\Link::getLink('index', empty($film) ? 'store' : 'update', empty($film) ? [] : ['id' => $film['id']]) ?>"
                  class="create-wrapper__form" method="post">
                <div class="action-wrapper">
                    <div class="link-wrapper">
                        <a href="<?= \App\Vendor\Link::getLink() ?>">Back</a>
                    </div>
                </div>
                <div class="form-group">
                    <input type="text" name="name" placeholder="Film name"
                           value="<?php if (!is_null($request->name)) echo $request->name; elseif (!empty($film)) echo $film['name']; else echo ''; ?>"
                           id="film_name">
                    <?php if ($errors->hasError('name')) { ?>
                        <div class="error">
                            <?= $errors->getFirstError('name') ?>
                        </div>
                    <?php } ?>
                </div>
                <div class="form-group">
                    <input type="text" name="year" placeholder="Year"
                           value="<?php if (!is_null($request->year)) echo $request->year; elseif (!empty($film)) echo $film['year']; else echo ''; ?>"
                           id="film_year">

                    <?php if ($errors->hasError('year')) { ?>
                        <div class="error">
                            <?= $errors->getFirstError('year') ?>
                        </div>
                    <?php } ?>
                </div>
                <div class="form-group">
                    <select name="format">
                        <?php foreach ($filmFormats as $filmFormat) { ?>
                            <?php if ($filmFormat == (!is_null($request->format) ? $request->format : (!empty($film) ? $film['format'] : ''))) { ?>
                                <option selected><?= $filmFormat ?></option>
                            <?php } else { ?>
                                <option><?= $filmFormat ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>

                    <?php if ($errors->hasError('format')) { ?>
                        <div class="error">
                            <?= $errors->getFirstError('format') ?>
                        </div>
                    <?php } ?>
                </div>
                <div class="form-group">
                    <textarea name="actors"
                              rows="5"
                              placeholder="Enter name and surname of actor. Every actor with a new line."
                              id="film_actors"><?php if (!is_null($request->actors)) echo $request->actors; elseif (!empty($film)) echo $film['actors']; else echo ''; ?></textarea>

                    <?php if ($errors->hasError('actors')) { ?>
                        <div class="error">
                            <?= $errors->getFirstError('actors') ?>
                        </div>
                    <?php } ?>
                </div>

                <?php if (empty($film)) { ?>
                    <div class="action-wrapper">
                        <input type="submit" value="Save">
                    </div>
                <?php } else { ?>
                    <div class="action-wrapper">
                        <div class="link-wrapper">
                            <a onclick="if (!confirm('Are you sure?')) return false;"
                               href="<?= \App\Vendor\Link::getLink('index', 'delete', ['id' => $film['id']]) ?>">Delete</a>
                        </div>
                        <input type="submit" value="Update">
                    </div>
                <?php } ?>
            </form>
        </div>
    </div>
</div>
<?= $footer ?>
