<?php
/**
 * The model file of ci module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Chenqi <chenqi@cnezsoft.com>
 * @package     product
 * @version     $Id: $
 * @link        http://www.zentao.net
 */

class ciModel extends model
{
    /**
     * Get a credential by id.
     *
     * @param  int    $id
     * @access public
     * @return object
     */
    public function getCredentialByID($id)
    {
        $credential = $this->dao->select('*')->from(TABLE_CREDENTIALS)->where('id')->eq($id)->fetch();
        return $credential;
    }

    /**
     * Get credential list.
     *
     * @param  string $orderBy
     * @param  object $pager
     * @param  bool   $decode
     * @access public
     * @return array
     */
    public function listCredential($orderBy = 'id_desc', $pager = null, $decode = true)
    {
        $credentials = $this->dao->select('*')->from(TABLE_CREDENTIALS)
            ->where('deleted')->eq('0')
            ->orderBy($orderBy)
            ->page($pager)
            ->fetchAll('id');
        return $credentials;
    }

    /**
     * Create a credential.
     *
     * @access public
     * @return bool
     */
    public function createCredential()
    {
        $credential = fixer::input('post')
            ->add('createdBy', $this->app->user->account)
            ->add('createdDate', helper::now())
//            ->remove('')
            ->get();

        $this->dao->insert(TABLE_CREDENTIALS)->data($credential)
            ->batchCheck($this->config->credential->create->requiredFields, 'notempty')
            ->autoCheck()
            ->exec();
        return !dao::isError();
    }

    /**
     * Update a credential.
     *
     * @param  int    $id
     * @access public
     * @return bool
     */
    public function updateCredential($id)
    {
        $credential = fixer::input('post')
            ->add('editedBy', $this->app->user->account)
            ->add('editedDate', helper::now())
            ->get();

        $this->dao->update(TABLE_CREDENTIALS)->data($credential)
            ->batchCheck($this->config->credential->edit->requiredFields, 'notempty')
            ->autoCheck()
            ->where('id')->eq($id)
            ->exec();
        return !dao::isError();
    }


    /**
     * Get a jenkins by id.
     *
     * @param  int    $id
     * @access public
     * @return object
     */
    public function getJenkinsByID($id)
    {
        $jenkins = $this->dao->select('*')->from(TABLE_JENKINS)->where('id')->eq($id)->fetch();
        return $jenkins;
    }

    /**
     * Get jenkins list.
     *
     * @param  string $orderBy
     * @param  object $pager
     * @param  bool   $decode
     * @access public
     * @return array
     */
    public function listJenkins($orderBy = 'id_desc', $pager = null, $decode = true)
    {
        $jenkinsList = $this->dao->select('*')->from(TABLE_JENKINS)
            ->where('deleted')->eq('0')
            ->orderBy($orderBy)
            ->page($pager)
            ->fetchAll('id');
        return $jenkinsList;
    }

    /**
     * Create a jenkins.
     *
     * @access public
     * @return bool
     */
    public function createJenkins()
    {
        $jenkins = fixer::input('post')
            ->add('createdBy', $this->app->user->account)
            ->add('createdDate', helper::now())
            ->get();

        $this->dao->insert(TABLE_JENKINS)->data($jenkins)
            ->batchCheck($this->config->jenkins->create->requiredFields, 'notempty')
            ->batchCheck("serviceUrl", 'URL')
            ->batchCheckIF($jenkins->type === 'credential', "credential", 'notempty')
            ->autoCheck()
            ->exec();
        return !dao::isError();
    }

    /**
     * Update a jenkins.
     *
     * @param  int    $id
     * @access public
     * @return bool
     */
    public function updateJenkins($id)
    {
        $jenkins = fixer::input('post')
            ->add('editedBy', $this->app->user->account)
            ->add('editedDate', helper::now())
            ->get();

        $this->dao->update(TABLE_JENKINS)->data($jenkins)
            ->batchCheck($this->config->jenkins->edit->requiredFields, 'notempty')
            ->batchCheck("serviceUrl", 'URL')
            ->batchCheckIF($jenkins->type === 'credential', "credential", 'notempty')
            ->autoCheck()
            ->where('id')->eq($id)
            ->exec();
        return !dao::isError();
    }

    /**
     * Get a ci task by id.
     *
     * @param  int    $id
     * @access public
     * @return object
     */
    public function getCitaskByID($id)
    {
        $jenkins = $this->dao->select('*')->from(TABLE_CI_TASK)->where('id')->eq($id)->fetch();
        return $jenkins;
    }

    /**
     * Get ci task list.
     *
     * @param  string $orderBy
     * @param  object $pager
     * @param  bool   $decode
     * @access public
     * @return array
     */
    public function listCitask($orderBy = 'id_desc', $pager = null, $decode = true)
    {
        $list = $this->dao->
            select('t1.*, t2.name repoName, t3.name as jenkinsName')->from(TABLE_CI_TASK)->alias('t1')
            ->leftJoin(TABLE_REPO)->alias('t2')->on('t1.repo=t2.id')
            ->leftJoin(TABLE_JENKINS)->alias('t3')->on('t1.jenkins=t3.id')
            ->where('t1.deleted')->eq('0')
            ->orderBy($orderBy)
            ->page($pager)
            ->fetchAll('id');
        return $list;
    }

    /**
     * Create a ci task.
     *
     * @access public
     * @return bool
     */
    public function createCitask()
    {
        $task = fixer::input('post')
            ->add('createdBy', $this->app->user->account)
            ->add('createdDate', helper::now())
            ->get();

        $this->dao->insert(TABLE_CI_TASK)->data($task)
            ->batchCheck($this->config->citask->requiredFields, 'notempty')
            ->batchCheckIF($task->triggerType === 'tag', "tagKeywords", 'notempty')
            ->batchCheckIF($task->triggerType === 'commit', "commentKeywords", 'notempty')

            ->batchCheckIF($task->triggerType === 'schedule' && $task->scheduleType == 'corn', "cornExpression", 'notempty')
            ->batchCheckIF($task->triggerType === 'schedule' && $task->scheduleType == 'custom', "scheduleDay,scheduleTime,scheduleInterval", 'notempty')

            ->autoCheck()
            ->exec();
        return !dao::isError();
    }

    /**
     * Update a ci task.
     *
     * @param  int    $id
     * @access public
     * @return bool
     */
    public function updateCitask($id)
    {
        $task = fixer::input('post')
            ->add('editedBy', $this->app->user->account)
            ->add('editedDate', helper::now())
            ->get();

        $this->dao->update(TABLE_CI_TASK)->data($task)
            ->batchCheck($this->config->citask->requiredFields, 'notempty')
            ->batchCheckIF($task->triggerType === 'tag', "tagKeywords", 'notempty')
            ->batchCheckIF($task->triggerType === 'commit', "commentKeywords", 'notempty')

            ->batchCheckIF($task->triggerType === 'schedule' && $task->scheduleType == 'corn', "cornExpression", 'notempty')
            ->batchCheckIF($task->triggerType === 'schedule' && $task->scheduleType == 'custom', "scheduleDay,scheduleTime,scheduleInterval", 'notempty')

            ->autoCheck()
            ->where('id')->eq($id)
            ->exec();
        return !dao::isError();
    }

    /**
     * Get a repo by id.
     *
     * @param  int    $id
     * @access public
     * @return object
     */
    public function getRepoByID($id)
    {
        $repo = $this->dao->select('*')->from(TABLE_REPO)->where('id')->eq($id)->fetch();
        return $repo;
    }

    /**
     * Get repo list.
     *
     * @param  string $orderBy
     * @param  object $pager
     * @param  bool   $decode
     * @access public
     * @return array
     */
    public function listRepo($orderBy = 'id_desc', $pager = null, $decode = true)
    {
        $repoList = $this->dao->select('*')->from(TABLE_REPO)
            ->where('deleted')->eq('0')
            ->orderBy($orderBy)
            ->page($pager)
            ->fetchAll('id');
        return $repoList;
    }

    /**
     * Create a repo.
     *
     * @access public
     * @return bool
     */
    public function createRepo()
    {
        $data = fixer::input('post')->skipSpecial('path,client,account,password')->get();
        if ($data->SCM === 'Subversion') {
            $credential = $this->getCredentialByID($data->credential);
            if ($credential->type != 'account') {
                dao::$errors['credential'][] = $this->repo->svnCredentialLimt;

                return;
            }
        }

        $this->checkRepoConnection();
        $data = fixer::input('post')->skipSpecial('path,client,account,password')->get();

        $data->acl = empty($data->acl) ? '' : json_encode($data->acl);
        if(empty($data->client)) $data->client = 'svn';

        if($data->SCM == 'Subversion')
        {
            $scm = $this->app->loadClass('scm');
            $scm->setEngine($data);
            $info = $scm->info('');
            $data->prefix = empty($info->root) ? '' : trim(str_ireplace($info->root, '', str_replace('\\', '/', $data->path)), '/');
            if($data->prefix) $data->prefix = '/' . $data->prefix;
        }

        if($data->encrypt == 'base64') $data->password = base64_encode($data->password);
        $this->dao->insert(TABLE_REPO)->data($data)
            ->batchCheck($this->config->repo->create->requiredFields, 'notempty')
            ->autoCheck()
            ->exec();
        return $this->dao->lastInsertID();
    }

    /**
     * Update a repo.
     *
     * @param  int    $id
     * @access public
     * @return bool
     */
    public function updateRepo($repoID)
    {
        $this->checkRepoConnection();
        $data = fixer::input('post')->skipSpecial('path,client,account,password')->get();
        $data->acl = empty($data->acl) ? '' : json_encode($data->acl);

        if(empty($data->client)) $data->client = 'svn';
        $repo = $this->getRepoByID($repoID);
        $data->prefix = $repo->prefix;
        if($data->SCM == 'Subversion' and $data->path != $repo->path)
        {
            $scm = $this->app->loadClass('scm');
            $scm->setEngine($data);
            $info = $scm->info('');
            $data->prefix = empty($info->root) ? '' : trim(str_ireplace($info->root, '', str_replace('\\', '/', $data->path)), '/');
            if($data->prefix) $data->prefix = '/' . $data->prefix;
        }
        elseif($data->SCM != $repo->SCM and $data->SCM == 'Git')
        {
            $data->prefix = '';
        }

        if($data->path != $repo->path) $data->synced = 0;
        if($data->encrypt == 'base64') $data->password = base64_encode($data->password);
        $this->dao->update(TABLE_REPO)->data($data)
            ->batchCheck($this->config->repo->create->requiredFields, 'notempty')
            ->autoCheck()
            ->where('id')->eq($repoID)->exec();
        if($repo->path != $data->path)
        {
            $this->dao->delete()->from(TABLE_REPOHISTORY)->where('repo')->eq($repoID)->exec();
            $this->dao->delete()->from(TABLE_REPOFILES)->where('repo')->eq($repoID)->exec();
            return false;
        }
        return true;
    }

    /**
     * Get git branches from scm.
     *
     * @param  object    $repo
     * @access public
     * @return array
     */
    public function getBranches($repo)
    {
        $this->scm = $this->app->loadClass('scm');
        $this->scm->setEngine($repo);
        return $this->scm->branch();
    }

    /**
     * Get git branches from db.
     *
     * @param  object    $repo
     * @access public
     * @return array
     */
    public function getBranchesFromDb($repoID)
    {
        $branches = $this->dao->select('*')->from(TABLE_REPOBRANCH)
            ->where('repo')->eq($repoID)
            ->fetchAll('repo');
        return $branches;
    }

    /**
     * Check repo connection
     *
     * @access public
     * @return void
     */
    public function checkRepoConnection()
    {
        if(empty($_POST)) return false;
        $scm      = $this->post->SCM;
        $client   = $this->post->client;
        $encoding = strtoupper($this->post->encoding);
        $path     = $this->post->path;
        if($encoding != 'UTF8' and $encoding != 'UTF-8') $path = helper::convertEncoding($path, 'utf-8', $encoding);

        $account  = "";
        $password = "";
        $privateKey = "";
        $passphrase = "";

        $credential = $this->getCredentialByID($this->post->credential);
        if ($credential->type === 'account') {
            $account = $credential->username;
            $password = $credential->password;

            $_POST['account'] = $account;
            $_POST['password'] = $password;
        } else {
            $privateKey = $credential->privateKey;
            $passphrase = $credential->passphrase;

            $_POST['privateKey'] = $privateKey;
            $_POST['passphrase'] = $passphrase;
        }

        if($scm == 'Subversion')
        {
            $path = '"' . $path . '"';
            if(stripos($path, 'https://') === 1 or stripos($path, 'svn://') === 1)
            {
                $ssh     = true;
                $remote  = true;
                $command = "$client info --username $account --password $password --non-interactive --trust-server-cert-failures=cn-mismatch --trust-server-cert --no-auth-cache $path 2>&1";
            }
            else if(stripos($path, 'file://') === 1)
            {
                $ssh     = false;
                $remote  = false;
                $command = "$client info --non-interactive --no-auth-cache $path 2>&1";
            }
            else
            {
                $ssh     = false;
                $remote  = true;
                $command = "$client info --username $account --password $password --non-interactive --no-auth-cache $path 2>&1";
            }
            exec($command, $output, $result);
            if($result)
            {
                $versionCommand = "$client --version --quiet 2>&1";
                exec($versionCommand, $versionOutput, $versionResult);
                if($versionResult)
                {
                    $message = sprintf($this->lang->repo->error->output, $versionCommand, $versionResult, join("\n", $versionOutput));
                    echo $message;
                    die(js::alert($this->lang->repo->error->cmd . '\n' . str_replace(array("\n", "'"), array('\n', '"'), $message)));
                }
                if($ssh and version_compare(end($versionOutput), '1.6', '<')) die(js::alert($this->lang->repo->error->version));
                $message = sprintf($this->lang->repo->error->output, $command, $result, join("\n", $output));
                echo $message;
                if(stripos($message, 'Expected FS format between') !== false and strpos($message, 'found format') !== false) die(js::alert($this->lang->repo->error->clientVersion));
                if(preg_match('/[^\:\/\\A-Za-z0-9_\-\'\"]/', $path)) die(js::alert($this->lang->repo->error->encoding . '\n' . str_replace(array("\n", "'"), array('\n', '"'), $message)));
                die(js::alert($this->lang->repo->error->connect . '\n' . str_replace(array("\n", "'"), array('\n', '"'), $message)));
            }
        }
        elseif($scm == 'Git')
        {
            if(!chdir($path))
            {
                if(!is_dir($path)) die(js::alert(sprintf($this->lang->repo->error->noFile, $path)));
                if(!is_executable($path)) die(js::alert(sprintf($this->lang->repo->error->noPriv, $path)));
                die(js::alert($this->lang->repo->error->path));
            }

            $command = "$client tag 2>&1";
            exec($command, $output, $result);
            if($result)
            {
                echo sprintf($this->lang->repo->error->output, $command, $result, join("\n", $output));
                die(js::alert($this->lang->repo->error->connect));
            }
        }
        return true;
    }

    /**
     * Get latest comment.
     *
     * @param  int    $repoID
     * @access public
     * @return object
     */
    public function getLatestComment($repoID, $branchID='')
    {
        $count = $this->dao->select('count(DISTINCT t1.id) as count')->from(TABLE_REPOHISTORY)->alias('t1')
            ->leftJoin(TABLE_REPOBRANCH)->alias('t2')->on('t1.id=t2.revision')
            ->where('t1.repo')->eq($repoID)
            ->beginIF($branchID)->andWhere('t2.branch')->eq($branchID)->fi()
            ->fetch('count');

        $lastComment = $this->dao->select('t1.*')->from(TABLE_REPOHISTORY)->alias('t1')
            ->leftJoin(TABLE_REPOBRANCH)->alias('t2')->on('t1.id=t2.revision')
            ->where('t1.repo')->eq($repoID)
            ->beginIF($branchID)->andWhere('t2.branch')->eq($branchID)->fi()
            ->orderBy('t1.time desc')
            ->limit(1)
            ->fetch();
        if(empty($lastComment)) return null;

        $repo = $this->getRepoByID($repoID);
        if($repo->SCM == 'Git' and $lastComment->commit != $count)
        {
            $this->fixCommit($repo->id);
            $lastComment->commit = $count;
        }

        return $lastComment;
    }

    /**
     * Save commit.
     *
     * @param  int    $repoID
     * @param  array  $logs
     * @param  int    $version
     * @param  string $branch
     * @access public
     * @return int
     */
    public function saveCommit($repoID, $logs, $version, $branch = '')
    {
        $count = 0;
        if(empty($logs)) return $count;

        foreach($logs['commits'] as $i => $commit)
        {
            $existsRevision  = $this->dao->select('id,revision')->from(TABLE_REPOHISTORY)->where('repo')->eq($repoID)->andWhere('revision')->eq($commit->revision)->fetch();
            if($existsRevision)
            {
                if($branch) $this->dao->replace(TABLE_REPOBRANCH)->set('repo')->eq($repoID)->set('revision')->eq($existsRevision->id)->set('branch')->eq($branch)->exec();
                continue;
            }

            $commit->repo    = $repoID;
            $commit->commit  = $version;
            $commit->comment = htmlspecialchars($commit->comment);
            $this->dao->insert(TABLE_REPOHISTORY)->data($commit)->exec();
            if(!dao::isError())
            {
                $commitID = $this->dao->lastInsertID();
                if($branch) $this->dao->replace(TABLE_REPOBRANCH)->set('repo')->eq($repoID)->set('revision')->eq($commitID)->set('branch')->eq($branch)->exec();
                foreach($logs['files'][$i] as $file)
                {
                    $parentPath = dirname($file->path);

                    $file->parent   = $parentPath == '\\' ? '/' : $parentPath;
                    $file->revision = $commitID;
                    $file->repo     = $repoID;
                    $this->dao->insert(TABLE_REPOFILES)->data($file)->exec();
                }
                $revisionPairs[$commit->revision] = $commit->revision;
                $version++;
                $count++;
            }
            else
            {
                dao::getError();
            }
        }
        return $count;
    }

    /**
     * Save exists log branch.
     *
     * @param  int    $repoID
     * @param  string $branch
     * @access public
     * @return void
     */
    public function saveExistsLogBranch($repoID, $branch)
    {
        $lastBranchLog = $this->dao->select('t1.time')->from(TABLE_REPOHISTORY)->alias('t1')
            ->leftJoin(TABLE_REPOBRANCH)->alias('t2')->on('t1.id=t2.revision')
            ->where('t1.repo')->eq($repoID)
            ->andWhere('t2.branch')->eq($branch)
            ->orderBy('time')
            ->limit(1)
            ->fetch();
        $stmt = $this->dao->select('*')->from(TABLE_REPOHISTORY)->where('repo')->eq($repoID)->andWhere('time')->lt($lastBranchLog->time)->query();
        while($log = $stmt->fetch())
        {
            $this->dao->REPLACE(TABLE_REPOBRANCH)->set('repo')->eq($repoID)->set('revision')->eq($log->id)->set('branch')->eq($branch)->exec();
        }
    }

    /**
     * Fix commit.
     *
     * @param  int    $repoID
     * @access public
     * @return void
     */
    public function fixCommit($repoID)
    {
        $stmt = $this->dao->select('DISTINCT t1.id')->from(TABLE_REPOHISTORY)->alias('t1')
            ->leftJoin(TABLE_REPOBRANCH)->alias('t2')->on('t1.id=t2.revision')
            ->where('t1.repo')->eq($repoID)
//            ->beginIF($this->cookie->repoBranch)->andWhere('t2.branch')->eq($this->cookie->repoBranch)->fi()
            ->orderBy('time')
            ->query();

        $i = 1;
        while($repoHistory = $stmt->fetch())
        {
            $this->dao->update(TABLE_REPOHISTORY)->set('`commit`')->eq($i)->where('id')->eq($repoHistory->id)->exec();
            $i++;
        }
    }

    /**
     * Mark synced status.
     *
     * @param  int    $repoID
     * @access public
     * @return void
     */
    public function markSynced($repoID)
    {
        $this->fixCommit($repoID);
        $this->dao->update(TABLE_REPO)->set('synced')->eq(1)->where('id')->eq($repoID)->exec();
    }

    /**
     * Create link for repo
     *
     * @param  string $method
     * @param  string $params
     * @param  string $pathParams
     * @param  string $viewType
     * @param  bool   $onlybody
     * @access public
     * @return string
     */
    public function createLink($method, $params = '', $pathParams = '', $viewType = '', $onlybody = false)
    {
        $link  = helper::createLink('ci', $method, $params, $viewType, $onlybody);
        if(empty($pathParams)) return $link;

        $link .= strpos($link, '?') === false ? '?' : '&';
        $link .= $pathParams;
        return $link;
    }

    /**
     * list credential for repo and jenkins edit page
     *
     * @param $whr
     * @return mixed
     */
    public function listCredentialForSelection($whr)
    {
        $credentials = $this->dao->select('id, name')->from(TABLE_CREDENTIALS)
            ->where('deleted')->eq('0')
            ->beginIF(!empty(whr))->andWhere($whr)->fi()
            ->orderBy(id)
            ->fetchPairs();
        $credentials[''] = '';
        return $credentials;
    }

    /**
     * list repos for jenkins task edit
     *
     * @return mixed
     */
    public function listRepoForSelection($whr)
    {
        $repos = $this->dao->select('id, name')->from(TABLE_REPO)
            ->where('deleted')->eq('0')
            ->beginIF(!empty(whr))->andWhere($whr)->fi()
            ->orderBy(id)
            ->fetchPairs();
        $repos[''] = '';
        return $repos;
    }

    /**
     * list repos for jenkins task edit
     *
     * @return mixed
     */
    public function listRepoForSync($whr)
    {
        $repos = $this->dao->select('*')->from(TABLE_REPO)
            ->where('deleted')->eq('0')
            ->beginIF(!empty(whr))->andWhere($whr)->fi()
            ->orderBy(id)
            ->fetchAll();
        $repos[''] = '';
        return $repos;
    }

    /**
     * list jenkins for ci task edit
     *
     * @return mixed
     */
    public function listJenkinsForSelection($whr)
    {
        $repos = $this->dao->select('id, name')->from(TABLE_JENKINS)
            ->where('deleted')->eq('0')
            ->beginIF(!empty(whr))->andWhere($whr)->fi()
            ->orderBy(id)
            ->fetchPairs();
        $repos[''] = '';
        return $repos;
    }

}
