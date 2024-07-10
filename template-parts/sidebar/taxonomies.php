
        <div><strong>Groups</strong></div>
        <div class="p-3 mb-3 bg-body-tertiary rounded-3">
        <?php
        $groups = get_categories(
            array(
                'taxonomy' => 'groups',
                'orderby' => 'id',
                'order' => 'DESC',
                'hide_empty' => '0'
            )
        );
        ?>
        <?php foreach ($groups as $g) : ?>
            <?php $active = '';
            if ($g->slug == $groupterm) $active = 'active'; ?>
            <div style="margin:0;padding:0;">
            <a class="<?= $active ?>" href="/learninghub/filter/?group[]=<?= $g->slug ?>">
                    <?= $g->name ?>
                </a>
                (<?= $g->count ?>)
            </div>
        <?php endforeach ?>
        </div>
        <div><strong>Topics</strong></div>
        <div class="p-3 mb-3 bg-body-tertiary rounded-3">
        <?php
        $topics = get_categories(
            array(
                'taxonomy' => 'topics',
                'orderby' => 'name',
                'order' => 'ASC',
                'hide_empty' => '0'
            )
        );
        ?>
        <?php foreach ($topics as $t) : ?>
            <?php $active = '';
            if ($t->slug == $topicterm) $active = 'active'; ?>
            <div style="margin:0;padding:0;">
            <a class="<?= $active ?>" href="/learninghub/filter/?topic[]=<?= $t->slug ?>">
                    <?= $t->name ?>
                </a>
                (<?= $t->count ?>)
            </div>
        <?php endforeach ?>
        </div>
        <div><strong>Audience</strong></div>
        <div class="p-3 mb-3 bg-body-tertiary rounded-3">
        <?php
        $audiences = get_categories(
            array(
                'taxonomy' => 'audience',
                'orderby' => 'id',
                'order' => 'ASC',
                'hide_empty' => '0'
            )
        );
        ?>
        <?php foreach ($audiences as $a) : ?>
            <?php $active = '';
            if ($a->slug == $audienceterm) $active = 'active'; ?>
            <div style="margin:0;padding:0;">
            <a class="<?= $active ?>" href="/learninghub/filter/?audience[]=<?= $a->slug ?>">
                    <?= $a->name ?>
                </a>
                (<?= $a->count ?>)
            </div>
        <?php endforeach ?>
        </div>
        <div><strong>Delivery Method</strong></div>
        <div class="p-3 mb-3 bg-body-tertiary rounded-3">
        <?php
        $dms = get_categories(
            array(
                'taxonomy' => 'delivery_method',
                'orderby' => 'id',
                'order' => 'ASC',
                'hide_empty' => '0',
                // 'include'   => array(65, 83, 119, 163, 567)
            )
        );
        ?>
        <?php foreach ($dms as $d) : ?>
            <?php $active = '';
            if ($d->slug == $dmterm) $active = 'active'; ?>
            <div style="margin:0;padding:0;">
            <a class="<?= $active ?>" href="/learninghub/filter/?delivery_method[]=<?= $d->slug ?>">
                    <?= $d->name ?>
                </a>
                (<?= $d->count ?>)
            </div>
        <?php endforeach ?>
        </div>