<!-- modal.php -->
<style>
    .grade-select {
        max-height: 150px !important;
        overflow-y: auto !important;
    }
</style>
<div class="modal fade" id="<?php echo $modalId; ?>" tabindex="-1" aria-labelledby="<?php echo $modalLabelId; ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="<?php echo $modalLabelId; ?>"><?php echo $modalTitle; ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo $formAction; ?>" method="post" id="<?php echo $formId; ?>" enctype="multipart/form-data">
                <div class="modal-body">
                    <?php echo $formContent; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>