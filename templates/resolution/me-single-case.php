<?php 
get_header();
$case_id = get_query_var( 'case_id' );
$case = me_get_message($case_id);
?>
<div id="marketengine-page">
    <div class="me-container">
        <div class="marketengine-content-wrap">

            <?php me_get_template('resolution/case-details/heading', array('case' => $case)); ?>
            <!-- marketengine-content -->
            <div class="marketengine-content">
                <?php if(!empty($_GET['action']) && $_GET['action'] == 'escalate') : ?>
                    <?php me_get_template('resolution/form/escalate', array('case' => $case) ) ?>
                <?php else : ?>
                    <?php me_get_template('resolution/case-details', array('case' => $case) ) ?>
                <?php endif; ?>
            </div>
            <!--// marketengine-content -->
        </div>
    </div>
</div>
<?php
get_footer();
?>
