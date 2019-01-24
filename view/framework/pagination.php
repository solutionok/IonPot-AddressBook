<?php
/**
 * This file should be used in concert with the following assumptions:
 * 1. $result variable should be populated by a call to getByOffset of BusinessDecorator
 * example: $result = $obj->getByOffset ( $start );
 * 2. $total vaiable should be populate by a call to getCount of BusinessDecorator
 * example: $totalCount = $obj->getCount () - should be called in scope
 * 3. LIMIT_PER_PAGE application level constant declared. May be in Config.php
 *
 * @version 1.2
 *
 */
$queryString = "?";

// To retain search query string
if (! empty($_q)) {
    $q = $_q . "&";
    $queryString = $queryString . $q;
}

// to retain order by
if (! empty($_GET["o"])) {
    $orderBy = "o=" . $_GET["o"] . "&";
    $queryString = $queryString . $orderBy;
}

// to retain order sequence
if (! empty($_GET["os"])) {
    $orderSeq = "os=" . $_GET["os"] . "&";
    $queryString = $queryString . $orderSeq;
}

$start = 0; // start offset of records
if (! empty($_GET["start"])) {
    $start = $_GET["start"];
}
$endRecordCount = $start + count($result);
$totalPages = ceil($totalCount / LIMIT_PER_PAGE);

$currentPageNumber = ($start / LIMIT_PER_PAGE) + 1;
?>
<div class="pagination" style="<?php if(!$totalCount) echo 'display:none;' ?>">
    <div class="records-info">
    <?php
    echo "Showing " . ($totalCount?($start + 1):0) . " to " . $endRecordCount . " of " . $totalCount . " entries.";
    ?>
    </div>
    <div class="pages">
    <?php
    if (($totalPages > 1) && ($currentPageNumber > 1)) {
        ?>
    <a class="prev-next"
            href="<?php echo $queryString;?>start=<?php echo (($currentPageNumber-2)*LIMIT_PER_PAGE);?>"
            title="Next Page"><span>&#10094; Previous</span></a>
            <?php
    }
    for ($i = 0; $i < $totalPages; $i ++) {
        $pageOffset = $i * LIMIT_PER_PAGE;
        $currentPage = false;
        if ($start == $i * LIMIT_PER_PAGE) {
            $currentPage = true;
        }

        if ($currentPage) {
            ?>
            <span title="Current Page"
            class="page <?php
            if ($start == $i * LIMIT_PER_PAGE) {
                echo "current";
            }
            ?>">
            <?php echo $i+1;?>
            </span>
            <?php
        } else {
            ?>
            <a
            href="<?php echo $queryString;?>start=<?php echo $pageOffset;?>">
            <span
            title="Page <?php echo $i+1;?> of <?php echo $totalPages;?>"
            class="page <?php
            if ($start == $i * LIMIT_PER_PAGE) {
                echo "current";
            }
            ?>">
            <?php echo $i+1;?>
            </span>
        </a>
            <?php
        }
    }
    if (($totalPages > 1) && ($currentPageNumber < $totalPages)) {
        ?>
        <a class="prev-next"
            href="<?php echo $queryString;?>start=<?php echo (($currentPageNumber)*LIMIT_PER_PAGE);?>"
            title="Next Page"><span>Next &#10095;</span></a>
        <?php
    }
    ?>
    </div>
</div>
<!-- pagination ends -->