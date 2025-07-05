<?php echo e(Form::model($maintainer, array('route' => array('maintainer.update', $maintainer->id), 'method' => 'PUT','enctype' => "multipart/form-data"))); ?>

<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6 col-lg-6">
            <?php echo e(Form::label('first_name',__('First Name'),array('class'=>'form-label'))); ?>

            <?php echo e(Form::text('first_name',$user->first_name,array('class'=>'form-control','placeholder'=>__('Enter First Name')))); ?>

        </div>
        <div class="form-group col-md-6 col-lg-6">
            <?php echo e(Form::label('last_name',__('Last Name'),array('class'=>'form-label'))); ?>

            <?php echo e(Form::text('last_name',$user->last_name,array('class'=>'form-control','placeholder'=>__('Enter Last Name')))); ?>

        </div>
        <div class="form-group col-md-6 col-lg-6 ">
            <?php echo e(Form::label('email',__('Email'),array('class'=>'form-label'))); ?>

            <?php echo e(Form::text('email',$user->email,array('class'=>'form-control','placeholder'=>__('Enter Email')))); ?>

        </div>
        <div class="form-group col-md-6 col-lg-6">
            <?php echo e(Form::label('phone_number',__('Phone Number'),array('class'=>'form-label'))); ?>

            <?php echo e(Form::text('phone_number',$user->phone_number,array('class'=>'form-control','placeholder'=>__('Enter Phone Number')))); ?>

        </div>
        <div class="form-group">
            <?php echo e(Form::label('property_id',__('Property'),array('class'=>'form-label'))); ?>

            <?php echo e(Form::select('property_id[]',$property,explode(',',$maintainer->property_id),array('class'=>'form-control hidesearch','id'=>'property','multiple'))); ?>

        </div>
        <div class="form-group">
            <?php echo e(Form::label('type_id',__('Type'),array('class'=>'form-label'))); ?>

            <?php echo e(Form::select('type_id',$types,null,array('class'=>'form-control hidesearch'))); ?>

        </div>
        <div class="form-group">
            <?php echo e(Form::label('profile',__('Profile'),array('class'=>'form-label'))); ?>

            <?php echo e(Form::file('profile',array('class'=>'form-control'))); ?>

        </div>
    </div>
</div>
<div class="modal-footer">
    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal"><?php echo e(__('Close')); ?></button>
    <?php echo e(Form::submit(__('Update'),array('class'=>'btn btn-primary btn-rounded'))); ?>

</div>
<?php echo e(Form::close()); ?>

<?php /**PATH C:\xampp\htdocs\property\resources\views/maintainer/edit.blade.php ENDPATH**/ ?>