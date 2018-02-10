

<?php






if (count($data)):?>


    <?php $box = $this->beginWidget('bootstrap.widgets.TbBox', array(
        'title' => 'company users',
        'headerIcon' => 'icon-user',
        // when displaying a table, if we include bootstra-widget-table class
        // the table will be 0-padding to the box
        'htmlOptions' => array('class'=>'bootstrap-widget-table'),
        'headerButtons' => array(
            array(
                'class' => 'bootstrap.widgets.TbButton',
                'type' => 'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                'label'=> 'Invite User',
                'visible'=>$user->admin==1,
                'url'=>UrlHelper::getPrefixLink('/user/invite'),

            )),
    ));


    ?>



    <table class="table tooltipster" >
        <thead >
        <tr>

            <th>Name</th>
            <th>Email</th>
            <th>Actions</th>

        </tr>
        </thead>

        <tbody>


        <?php foreach($data as $item) {?>
            <tr class="odd">
                <td>
                    <?php if($item['admin']==1) { ?>
                        <i class="icon-user" rel="tooltip" title="Administrator"></i>

                    <?php } ?>
                </td>
                <td>
                    <?php echo $item['firstname']." ".$item['lastname'];?>
                </td>
                <td>
                    <?php echo $item['email'];?>
                </td>
                <td>

                    <?php    if($user->id==$item['id'] && $user->admin!=1) {?>
                        <a href="<?php echo UrlHelper::getPrefixLink('/user/view/id/')?><?php echo $item['id'];?>"><i class="icon-eye-open" rel="tooltip" title="View"></i></a>

                    <?php }?>
                    <?php    if($user->admin==1) {?>
                        <?php    if($item['link']!=0) {?>
                            <a href="<?php echo UrlHelper::getPrefixLink('/user/reinvite/id/')?><?php echo $item['id'];?>"><i class="icon-envelope" rel="tooltip" title="Resend Invitation Email"></i></a>
                        <?php }?>
                        <a href="<?php echo UrlHelper::getPrefixLink('/user/view/id/')?><?php echo $item['id'];?>"><i class="icon-eye-open" rel="tooltip" title="View"></i></a>

                        <?php if($item['admin']==1 && count($admin)>1) {?>
                            <a href="<?php echo UrlHelper::getPrefixLink('/user/demote/id/')?><?php echo $item['id'];?>"><i class="icon-circle-arrow-down" rel="tooltip" title="Remove Administrator Rights"></i> </a>
                        <?php }?>
                        <?php if($item['admin']!=1) {?>
                            <a href="<?php echo UrlHelper::getPrefixLink('/user/promote/id/')?><?php echo $item['id'];?>"><i class="icon-circle-arrow-up" rel="tooltip" title="Promote to Administrator"></i> </a>

                            <a href="<?php echo UrlHelper::getPrefixLink('/user/sack/id/')?><?php echo $item['id'];?>"><i class="icon-remove-sign" rel="tooltip" title="Remove user from company"></i></a>
                        <?php }?>
                    <?php }?>

                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

    <?php

    $this->endWidget();
endif;



