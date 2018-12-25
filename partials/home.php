<form method="get">
    <div class="form-group">
        <div class="input-group">
            <input type="text" class="form-control" name="q" <?php if (!empty($_GET['q'])): ?> value="<?=$_GET['q'];?>" <?php endif; ?> placeholder="Search for titles or content..." autofocus>
            <span class="input-group-btn">
            <button class="btn btn-default" type="submit"><i class="fa fa-search fa-fw"></i></button>
        </span>
        </div>
    </div>
</form>
<?php

$page = 1;
if (!empty($_GET['page'])) {
    $page = (int) $_GET['page'];
}
$items = 5; // change to show how many per loop
if (!empty($_GET['items'])) {
    $items = (int) $_GET['items'];
}

if ($page == 1) {
    $start = 1;
} else {
    $start = ($items * ($page - 1)) + 1;
}

$q = null;
if (!empty($_GET['q']))
    $q = $_GET['q'];

$files = glob(APP_ROOT . "content/*.1.txt"); // .1.txt is published, .0.txt is a draft.
if (!empty($q)) {
    foreach ($files as $skey => $sfile) {
        if (!in_file($q, $sfile)) {
            unset($files[$skey]);
        }
    }
}

usort($files, function($a, $b) {
    return filemtime($a) < filemtime($b);
});

$last_item = 0;

if (count($files) == 0) {
    echo "<p>There is no published content found for your query.</p>";
} else { ?>
    <?php if (!empty($_GET['q'])): ?>
        <p>Results: <?=number_format(count($files)); ?> (<?=number_format($items); ?> results per page)</p>
    <?php endif; ?>
    <?php for ($i = $start; $i <= $start + ($items - 1); $i++): ?>
        <?php $x = $i - 1; ?>
        <?php if (!empty($files[$x])): ?>
            <?php $url = make_slug($files[$x]); ?>
            <div class="section-post">
                <h2>
                    <a href="<?=$url; ?>"><?=get_meta($files[$x], "Title"); ?></a>
                </h2>
                <p class="posted-on"><?php if (get_meta($files[$x], "Date") == false): ?><?=date("F j, Y", filemtime($files[$x])); ?><?php else: ?><?=get_meta($files[$x], "Date"); ?><?php endif; ?></p>
                <p>
                    <?=get_excerpt($files[$x], 150, $q); ?> <a href="<?=$url; ?>">Read more</a>
                </p>
            </div>
            <hr>
            <?php $last_item = $i; ?>
        <?php endif; ?>
    <?php endfor; ?>
    <?php if (($page - 1 > 0) || ($last_item < count($files))): ?>
        <table style="width: 100%; margin-bottom: 1em;">
            <tr>
                <td>
                    <?php if ($page - 1 > 0): ?>
                        <a href="<?=modify_get(['page' => $page - 1]); ?>"><i class="fa fa-angle-left fa-fw"></i> Previous</a>
                    <?php endif; ?>
                </td>
                <td class="text-right">
                    <?php if ($last_item < count($files)): ?>
                        <a href="<?=modify_get(['page' => $page + 1]); ?>">Next <i class="fa fa-angle-right fa-fw"></i></a>
                    <?php endif; ?>
                </td>
            </tr>
        </table>
    <?php endif; ?>
<?php } ?>
