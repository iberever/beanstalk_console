<div class="navbar navbar-fixed-top navbar-default" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">Beanstalk console</a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <?php if ($server && $tube): ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <?php echo $server ?> <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="index.php">All servers</a></li>
                            <?php foreach (array_diff($servers, array($server)) as $serverItem): ?>
                                <li><a href="index.php?server=<?php echo $serverItem ?>"><?php echo $serverItem ?></a></li>
                            <?php endforeach ?>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <?php echo $tube ?> <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="index.php?server=<?php echo $server ?>">All tubes</a></li>
                            <?php foreach (array_diff($tubes, array($tube)) as $tubeItem): ?>
                                <li><a href="index.php?server=<?php echo $server ?>&tube=<?php echo $tubeItem ?>"><?php echo $tubeItem ?></a></li>
                            <?php endforeach ?>
                        </ul>
                    </li>
                <?php elseif ($server): ?>
                    <?php $server = !is_array($server) ? array($server) : $server; ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Servers<span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="index.php">List All</a></li>
                            <?php foreach ($servers as $serverItem): ?>
                                <?php if(in_array($serverItem,$server)): ?>
                                    <li class="disabled"><a href="#"><?php echo $serverItem; ?></a></li>
                                <?php else: ?>
                                    <li><a href="index.php?server=<?php echo $serverItem; ?>"><?php echo $serverItem; ?></a></li>
                                <?php endif; ?>
                            <?php endforeach ?>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            All tubes <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <?php if (isset($tubes) && is_array($tubes)):?>
                                <?php
                                    $i = 0;
                                    $size = count($server);
                                ?>
                                <?php foreach($tubes as $server => $tubesByServer) : ?>
                                    <li class="dropdown-header"><?php echo $server; ?></li>
                                    <?php foreach ($tubesByServer as $tubeItem): ?>
                                        <li><a href="index.php?server=<?php echo $server ?>&tube=<?php echo $tubeItem ?>"><?php echo $tubeItem ?></a></li>
                                    <?php endforeach; ?>
                                    <?php if($i !== $size -1): ?>
                                        <li class="divider" role="separator"></li>
                                    <?php endif; ?>
                                    <?php $i++; ?>
                                <?php endforeach; ?>
                            <?php endif;?>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            All servers <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <?php foreach ($servers as $serverItem): ?>
                                <li><a href="index.php?server=<?php echo $serverItem ?>"><?php echo $serverItem ?></a></li>
                            <?php endforeach ?>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Toolbox <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <?php if (!isset($_tplPage) && !$server) : ?>
                            <li><a href="#filterServer" role="button" data-toggle="modal">Filter columns</a></li>
                        <?php elseif (!isset($_tplPage) && $server): ?>
                            <li><a href="#filter" role="button" data-toggle="modal">Filter columns</a></li>
                        <?php endif;?>
                        <?php if ($server && !$tube) : ?>
                            <li><a href="#clear-tubes" role="button" data-toggle="modal">Clear multiple tubes</a></li>
                        <?php endif; ?>
                        <li><a href="index.php?action=manageSamples" role="button">Manage samples</a></li>
                        <li class="divider"></li>
                        <li><a href="#settings" role="button" data-toggle="modal">Edit settings</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Links <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="https://github.com/kr/beanstalkd">Beanstalk (github)</a></li>
                        <li><a href="https://github.com/kr/beanstalkd/blob/master/doc/protocol.md">Protocol Specification</a></li>
                        <li class="divider"></li>
                        <li><a href="https://github.com/ptrofimov/beanstalk_console">Beanstalk console (github)</a></li>
                    </ul>
                </li>
                <?php if ($server && !$tube): ?>
                    <li>
                        <button type="button" id="autoRefresh" class="btn btn-default btn-small">
                            <span class="glyphicon glyphicon-refresh"></span>
                        </button>
                    </li>
                <?php elseif (!$tube) : ?>
                    <li>
                        <button type="button" id="autoRefreshSummary" class="btn btn-default btn-small">
                            <span class="glyphicon glyphicon-refresh"></span>
                        </button>
                    </li>
                <?php endif; ?>
            </ul>
            <?php if (isset($server, $tube) && $server && $tube): ?>
                <form  class="navbar-form navbar-right" style="margin-top:5px;margin-bottom:0px;" role="search" action="" method="get">
                    <input type="hidden" name="server" value="<?php echo $server; ?>"/>
                    <input type="hidden" name="tube" value="<?php echo $tube; ?>"/>
                    <input type="hidden" name="state" value="<?php echo $state; ?>"/>
                    <input type="hidden" name="action" value="search"/>
                    <input type="hidden" name="limit" value="<?php echo empty($_COOKIE['searchResultLimit']) ? 25 : $_COOKIE['searchResultLimit']; ?>"/>
                    <div class="form-group">
                        <input type="text" class="form-control input-sm search-query" name="searchStr" placeholder="Search this tube">
                    </div>
                </form>
            <?php endif; ?>
        </div>
        <!--/.nav-collapse -->
    </div>
</div>