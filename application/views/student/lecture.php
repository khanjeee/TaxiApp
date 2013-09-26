<div style="width:530px;">
    <h3>Lecture</h3>
    <div class="notice">
        <div class="notice-header box-header" style="float: left;">
            <div class="notice-title">
                <p><?= $lecture->topic; ?></p>
            </div>
            <div class="notice-date">
                <b>Date:</b> <?= date('D, d M Y', strtotime($lecture->lecture_date)); ?>
            </div>
        </div>
        <div class="clear"></div>
        <div class="notice-body">
            <div>Day: <?= $lecture->day; ?></div>
            <div class="notice-desc">
                <?= $lecture->topic_desc; ?>
            </div>
            <div><h4>Lecture Material</h4></div>
            <?php
            $lec_file = "";
            if(!empty($lecture->uploaded_file)) {
                $lec_file = "<a href='".site_url(UPLOAD_LECTURES_FILE.'/'. $lecture->uploaded_file)."'>". $lecture->uploaded_file ."</a>";
            }
            $lec_audiofile = "";
            if(!empty($lecture->uploaded_audio)){
                $lec_audiofile = "<a href='".site_url(UPLOAD_LECTURES_AUDIO.'/'. $lecture->uploaded_audio)."'>". $lecture->uploaded_audio ."</a>";
            }

            ?>
            <div>File:  <?= $lec_file; ?></div>
            <div>Audio: <?= $lec_audiofile; ?></div>
            <div><h3></h3></div>
            <div>Refer Link: <?= $lecture->refer_links; ?></div>
            <div>Tag: <?= $lecture->tags; ?></div>

        </div>
    </div>
</div>
