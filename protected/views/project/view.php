<?php

//echo Yii::App()->session['project']; die;

$project=Project::model()->findbyPK(Yii::App()->session['project']);

echo '<h1>'.$project->name;?>
 <a href = "/project/edit"><i class="icon-edit"></i></a></h1>
<?php


$data = Config::model()->getRecentConfigs();

if (!empty($data)) {
    $box = $this->beginWidget('bootstrap.widgets.TbBox', array(
        'title' => 'Recent Configuration Changes',
        'headerIcon' => 'icon-briefcase',
        // when displaying a table, if we include bootstra-widget-table class
        // the table will be 0-padding to the box
        'htmlOptions' => array('class' => 'bootstrap-widget-table'),
        'headerButtons' => array(

            array(
                'class' => 'bootstrap.widgets.TbButton',
                'type' => 'success', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                'label' => 'Add Configuration  +',

                'url' => UrlHelper::getPrefixLink('/config/create/'),
            ),


        )

    ));


    ?>
    <table class="table">
        <thead>
        <tr>
            <th>Name</th>


        </tr>
        </thead>
        <tbody>
        <?php if (count($data)): ?>


            <?php foreach ($data as $item): ?>


                <tr class="odd">
                    <td>
                        <a href="/system/view/id/<?php $item->system_id; ?>"><?php echo $item->name; ?></a>
                        - <?php echo $item->description; ?>
                    </td>
                    <td>
                        <?php echo $item->creator->firstname . ' ' . $item->creator->lastname . ' ' . $item->create_date; ?>
                    </td>

                </tr>
                <?php

            endforeach;
        endif;

        ?>

        </tbody>
    </table>

    <?php $this->endWidget();
}



$data = $project->systems;




    $box = $this->beginWidget('bootstrap.widgets.TbBox', array(
        'title' => 'Systems',
        'headerIcon' => 'icon-briefcase',
        // when displaying a table, if we include bootstra-widget-table class
        // the table will be 0-padding to the box
        'htmlOptions' => array('class' => 'bootstrap-widget-table'),
        'headerButtons' => array(

            array(
                'class' => 'bootstrap.widgets.TbButton',
                'type' => 'success', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                'label' => 'Add System  +',

                'url' => UrlHelper::getPrefixLink('/system/create/'),
            ),


        )
    ));

    if (!empty($data)) {
    ?>
    <table class="table">
        <thead>
        <tr>
            <th>Name</th>


        </tr>
        </thead>
        <tbody>
        <?php if (count($data)): ?>


            <?php foreach ($data as $item): ?>



                <tr class="odd">
                    <td>
                        <a href="<?php echo UrlHelper::getPrefixLink('/system/view/id/') ?><?php echo $item->id; ?>"><?php echo $item->name; ?></a>
                        - <?php echo $item->description;
                        ?>
                    </td>


                </tr>
            <?php endforeach ?>


        <?php endif; ?>


        </tbody>
    </table>

    <?php
    }
        $this->endWidget();


?>