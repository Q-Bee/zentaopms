<?php
/**
 * The testtask module English file of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     testtask
 * @version     $Id: en.php 4490 2013-02-27 03:27:05Z wyd621@gmail.com $
 * @link        http://www.zentao.net
 */
$lang->testtask->index            = "Home";
$lang->testtask->create           = "Submit Test";
$lang->testtask->reportChart      = 'Report';
$lang->testtask->delete           = "Delete";
$lang->testtask->view             = "Overview";
$lang->testtask->edit             = "Edit";
$lang->testtask->browse           = "Test";
$lang->testtask->linkCase         = "Link Case";
$lang->testtask->selectVersion    = "Select Version";
$lang->testtask->unlinkCase       = "Unlink";
$lang->testtask->batchUnlinkCases = "Batch Unlink Case";
$lang->testtask->batchAssign      = "Batch Assign";
$lang->testtask->runCase          = "Run";
$lang->testtask->batchRun         = "Batch run";
$lang->testtask->results          = "Result";
$lang->testtask->createBug        = "Bug(+)";
$lang->testtask->assign           = 'Assign';
$lang->testtask->cases            = 'Case';
$lang->testtask->groupCase        = "By Group";
$lang->testtask->pre              = 'Prev.';
$lang->testtask->next             = 'Next';
$lang->testtask->start            = "Start";
$lang->testtask->close            = "Close";
$lang->testtask->wait             = "Pending";
$lang->testtask->block            = "Block";
$lang->testtask->activate         = "Activate";
$lang->testtask->testing          = "Testing";
$lang->testtask->blocked          = "Blocked";
$lang->testtask->done             = "Tested";
$lang->testtask->totalStatus      = "All";
$lang->testtask->all              = "All " . $lang->productCommon;
$lang->testtask->allTasks         = 'All Tests';
$lang->testtask->collapseAll      = 'Collapse';
$lang->testtask->expandAll        = 'Expand';

$lang->testtask->id             = 'ID';
$lang->testtask->common         = 'Test';
$lang->testtask->product        = $lang->productCommon;
$lang->testtask->project        = $lang->projectCommon;
$lang->testtask->build          = 'Build';
$lang->testtask->owner          = 'Owner';
$lang->testtask->pri            = 'Priority';
$lang->testtask->name           = 'Name';
$lang->testtask->begin          = 'Begin';
$lang->testtask->end            = 'End';
$lang->testtask->desc           = 'Description';
$lang->testtask->mailto         = 'Mailto';
$lang->testtask->status         = 'Status';
$lang->testtask->assignedTo     = 'Assigned';
$lang->testtask->linkVersion    = 'Build';
$lang->testtask->lastRunAccount = 'Last Run by';
$lang->testtask->lastRunTime    = 'Last Run on';
$lang->testtask->lastRunResult  = 'Result';
$lang->testtask->reportField    = 'Report';
$lang->testtask->files          = 'Upload';
$lang->testtask->case           = 'Case';
$lang->testtask->version        = 'Version';
$lang->testtask->caseResult     = 'Test Result';
$lang->testtask->stepResults    = 'Step Result';
$lang->testtask->lastRunner     = 'Last Run by';
$lang->testtask->lastRunDate    = 'Last Run on';
$lang->testtask->date           = 'Tested on';;

$lang->testtask->beginAndEnd    = 'Duration';
$lang->testtask->to             = 'To';

$lang->testtask->legendDesc      = 'Description';
$lang->testtask->legendReport    = 'Report';
$lang->testtask->legendBasicInfo = 'Basic Info';

$lang->testtask->statusList['wait']    = 'Pending';
$lang->testtask->statusList['doing']   = 'Doing';
$lang->testtask->statusList['done']    = 'Done';
$lang->testtask->statusList['blocked'] = 'Blocked';

$lang->testtask->priList[0] = '';
$lang->testtask->priList[3] = '3';
$lang->testtask->priList[1] = '1';
$lang->testtask->priList[2] = '2';
$lang->testtask->priList[4] = '4';

$lang->testtask->unlinkedCases = 'Unlinked Case';
$lang->testtask->linkByBuild   = 'Copy from build';
$lang->testtask->linkByStory   = 'Link by Story';
$lang->testtask->linkByBug     = 'Link by Bug';
$lang->testtask->linkBySuite   = 'Link by Suite';
$lang->testtask->passAll       = 'Pass all';
$lang->testtask->pass          = 'Pass';
$lang->testtask->fail          = 'Failed';
$lang->testtask->showResult    = 'Executed <span class="text-info">%s</span> times';
$lang->testtask->showFail      = 'Failed <span class="text-danger">%s</span> times';

$lang->testtask->confirmDelete     = 'Do you want to delete this test build?';
$lang->testtask->confirmUnlinkCase = 'Do you want to unlink this case?';
$lang->testtask->noticeNoOther     = 'There are no other tests for this product';
$lang->testtask->noTesttask        = 'No tests. ';
$lang->testtask->checkLinked       = "Please check whether the product that the test is linked to has been linked to a project.";

$lang->testtask->assignedToMe  = 'AssignToMe';
$lang->testtask->allCases      = 'All Cases';

$lang->testtask->lblCases      = 'Case';
$lang->testtask->lblUnlinkCase = 'Unlink Case';
$lang->testtask->lblRunCase    = 'Execute Case';
$lang->testtask->lblResults    = 'Result';

$lang->testtask->placeholder = new stdclass();
$lang->testtask->placeholder->begin = 'Begin';
$lang->testtask->placeholder->end   = 'End';

$lang->testtask->mail = new stdclass();
$lang->testtask->mail->create = new stdclass();
$lang->testtask->mail->edit   = new stdclass();
$lang->testtask->mail->close  = new stdclass();
$lang->testtask->mail->create->title = "%s created test #%s:%s";
$lang->testtask->mail->edit->title   = "%s finished test #%s:%s";
$lang->testtask->mail->close->title  = "%s closed test #%s:%s";

$lang->testtask->action = new stdclass();
$lang->testtask->action->testtaskopened  = '$date,  <strong>$actor</strong> submitted test <strong>$extra</strong>.' . "\n";
$lang->testtask->action->testtaskstarted = '$date,  <strong>$actor</strong> started test <strong>$extra</strong>.' . "\n";
$lang->testtask->action->testtaskclosed  = '$date,  <strong>$actor</strong> completed test<strong>$extra</strong>.' . "\n";

$lang->testtask->unexecuted = 'Not performed';

/* 统计报表。*/
$lang->testtask->report = new stdclass();
$lang->testtask->report->common = 'Report';
$lang->testtask->report->select = 'Type';
$lang->testtask->report->create = 'Generate';

$lang->testtask->report->charts['testTaskPerRunResult'] = 'Test Result Report';
$lang->testtask->report->charts['testTaskPerType']      = 'Type Report';
$lang->testtask->report->charts['testTaskPerModule']    = 'Module Report';
$lang->testtask->report->charts['testTaskPerRunner']    = 'RunBy Report';
$lang->testtask->report->charts['bugSeverityGroups']    = 'Bug Severity Distribution';
$lang->testtask->report->charts['bugStatusGroups']      = 'Bug Status Distribution';
$lang->testtask->report->charts['bugOpenedByGroups']    = 'Bug CreateBy Distribution';
$lang->testtask->report->charts['bugResolvedByGroups']  = 'Bug ResolveBy Distribution';
$lang->testtask->report->charts['bugResolutionGroups']  = 'Bug Resolution Distribution';
$lang->testtask->report->charts['bugModuleGroups']      = 'Bug Module Distribution';

$lang->testtask->report->options = new stdclass();
$lang->testtask->report->options->graph  = new stdclass();
$lang->testtask->report->options->type   = 'pie';
$lang->testtask->report->options->width  = 500;
$lang->testtask->report->options->height = 140;
