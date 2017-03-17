<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */




    $user = User::model()->findbyPK(Yii::App()->user->id);
echo $user->mycompany->name;



    $data = $user->mycompany->project;




if (!empty($data)) {

    $box = $this->beginWidget('bootstrap.widgets.TbBox', array(
        'title' => 'Recent Projects',
        'headerIcon' => 'icon-briefcase',
        // when displaying a table, if we include bootstra-widget-table class
        // the table will be 0-padding to the box
        'htmlOptions' => array('class' => 'bootstrap-widget-table'),
        'headerButtons' => array(
            array(
                'class' => 'bootstrap.widgets.TbButton',
                'type' => 'info', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                'label' => 'Library',
                'icon' => 'book',
                'url' => ('/library/view'),
            ),
            array(
                'class' => 'bootstrap.widgets.TbButton',
                'type' => 'info', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                'label' => 'All Projects',

                'url' => ('/project/myrequirements/stage/1'),
            ),
            array(
                'class' => 'bootstrap.widgets.TbButton',
                'type' => 'success', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                'label' => 'Add Project  +',

                'url' => UrlHelper::getPrefixLink('/project/create/stage/1'),
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


            <?php foreach ($data as $itemIdx => $item): ?>



                <tr class="odd">
                    <td>
                        <a href="<?php echo UrlHelper::getPrefixLink('/project/set/id/') ?><?php echo $item['id']; ?>"><?php echo $item['name']; ?></a>
                        - <?php echo $item['description']; ?>
                    </td>


                </tr>
            <?php endforeach ?>


        <?php endif; ?>


        </tbody>
    </table>

    <?php $this->endWidget();

}
    ?>