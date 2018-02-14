<?php

//echo Yii::App()->session['project']; die;

$project=Project::model()->findbyPK(Yii::App()->session['project']);

echo '<h1>'.$project->name;

if (Yii::App()->session['projectOwner']) {
    ?>

    <a href="/project/edit"><i class="icon-edit"></i></a>
    <a href="/project/delete" onclick="return confirm('Are you sure you want to delete this project?');"><i class="icon-remove-sign"></i></a>
    <?php
}
    ?>


    </h1>
<?php

$data = Config::model()->getRecentConfigs();


    $box = $this->beginWidget('bootstrap.widgets.TbBox', array(
        'title' => 'Recent Configuration Changes',
        'headerIcon' => 'icon-briefcase',
        // when displaying a table, if we include bootstra-widget-table class
        // the table will be 0-padding to the box
        'htmlOptions' => array('class' => 'bootstrap-widget-table'),
        'headerButtons' => array(


            array(
                'class' => 'bootstrap.widgets.TbButton',
                'type' => 'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                'label' => 'View History',

                'url' => UrlHelper::getPrefixLink('/project/history/'),
            ),
            array(
                'class' => 'bootstrap.widgets.TbButton',
                'type' => 'success', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                'label' => 'Add Configuration  +',

                'url' => UrlHelper::getPrefixLink('/config/create/'),
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
                        <a href="/config/view/id/<?php echo $item->id; ?>"><?php echo $item->name; ?></a>
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

    <?php
}

$this->endWidget();
$data = $project->systems;
//echo '<pre>';
//print_r($data);




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


            <?php foreach ($data as $item):


                $link=Projectsystem::model()->find('system_id = '.$item->id.' and project_id = '.Yii::App()->session['project'].' order by id desc');
                if($item->deleted == 0 && $link->deleted==0) {


                    ?>


                    <tr class="odd">
                        <td>


                            <a href="<?php echo UrlHelper::getPrefixLink('/system/view/id/') ?><?php echo $item->id; ?>"><?php echo $item->name; ?></a>
                            - <?php echo $item->description; ?>
                        </td>
                        <td>
                            <?php
                            if ($item->type == 1) {
                                ?>(shared system) <a href="/project/unlink/id/<?php echo $item->id; ?>"><i
                                        class="icon-unlink"></i></a>

                                <?php
                            } else {

                                ?><a href="/project/systemdelete/id/<?php echo $item->id; ?>"><i
                                        class="icon-remove-sign"></i></a>

                                <?php
                            }
                            ?>

                        </td>


                    </tr>
                    <?php
                }
                endforeach ?>


        <?php endif; ?>


        </tbody>
    </table>

    <?php
    }
        $this->endWidget();


?>