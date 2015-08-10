<?php
/**
 * The blog view file for mobile template of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1 (http://www.chanzhi.org/license/)
 * @author      Hao Sun <sunhao@cnezsoft.com>
 * @package     blog
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include TPL_ROOT . 'blog/header.html.php';?>

<?php
$root = '<li><span class="breadcrumb-title">' . $this->lang->currentPos . $this->lang->colon . '</span>' .  html::a($this->inlink('index'), $lang->blog->home) . '</li>';
if(!empty($category)) echo $common->printPositionBar($category, '', '', $root);
?>
<div class='block-region region-top'><?php $this->loadModel('block')->printRegion($layouts, 'blog_view', 'top');?></div>

<div class='appheader'>
  <div class='heading'>
    <h2><?php echo $article->title;?></h2>
    <div class='caption text-muted'>
      <small><i class='icon-time icon-large'></i> <?php echo formatTime($article->addedDate); ?></small> &nbsp;&nbsp;
      <small><i class='icon-user icon-large'></i> <?php echo $article->author; ?></small> &nbsp;&nbsp;
      <small><i class='icon-eye-open'></i> <?php echo $article->views; ?></small> &nbsp;&nbsp;
      <?php if($article->source != 'original' and $article->copyURL != ''):?>
      <small><?php echo $lang->article->sourceList[$article->source] . $lang->colon;?><?php $article->copyURL ? print(html::a($article->copyURL, $article->copySite, "target='_blank'")) : print($article->copySite); ?></small>
      <?php else: ?>
      <small class='text-success bg-success-pale'><?php echo $lang->article->sourceList[$article->source]; ?></small>
      <?php endif;?>
    </div>
  </div>
</div>

<div class='panel-section article'>
  <?php if($article->summary):?>
  <section class='abstract bg-gray-pale small with-padding'><strong><?php echo $lang->article->summary;?></strong><?php echo $lang->colon . $article->summary;?></section>
  <?php endif; ?>
  <div class='panel-body'>
    <hr class="space">
    <section class='article-content'>
      <?php echo $article->content;?>
    </section>
  </div>
  <?php if(!empty($article->files)):?>
  <section class="article-files">
    <?php $this->loadModel('file')->printFiles($article->files);?>
  </section>
  <?php endif;?>
  <div class='panel-footer'>
    <div class='article-moreinfo clearfix'>
      <?php if($article->editor):?> 
      <?php $editor = $this->loadModel('user')->getByAccount($article->editor);?>
      <?php if(!empty($editor)): ?> 
      <p class='text-right pull-right'><?php printf($lang->article->lblEditor, $editor->realname, formatTime($article->editedDate));?></p>
      <?php endif;?>
      <?php endif;?>
      <?php if($article->keywords):?>
      <p class='small'><strong class="text-muted"><?php echo $lang->article->keywords;?></strong><span class="article-keywords"><?php echo $lang->colon . $article->keywords;?></span></p>
      <?php endif; ?>
    </div>
    <?php extract($prevAndNext);?>
    <ul class='pager pager-justify'>
      <?php if($prev): ?>
      <li class='previous'><?php echo html::a(inlink('view', "id=$prev->id", "category={$category->alias}&name={$prev->alias}"), '<i class="icon-arrow-left"></i> ' . $lang->article->previous, "title='{$prev->title}'"); ?></li>
      <?php else: ?>
      <li class='previous disabled'><a href='###'><i class='icon-arrow-left'></i> <?php print($lang->article->none); ?></a></li>
      <?php endif; ?>
      <?php if($next):?>
      <li class='next'><?php echo html::a(inlink('view', "id=$next->id", "category={$category->alias}&name={$next->alias}"), $lang->article->next . ' <i class="icon-arrow-right"></i>', "title='{$next->title}'"); ?></li>
      <?php else:?>
      <li class='next disabled'><a href='###'><?php print($lang->article->none); ?><i class='icon-arrow-right'></i></a></li>
      <?php endif; ?>
    </ul>
  </div>
</div>

<?php if(commonModel::isAvailable('message')):?>
<div id='commentBox'><?php echo $this->fetch('message', 'comment', "objectType=article&objectID={$article->id}");?></div>
<?php endif;?>

<div class='block-region region-bottom'><?php $this->loadModel('block')->printRegion($layouts, 'blog_view', 'bottom');?></div>

<?php include TPL_ROOT . 'blog/footer.html.php';?>