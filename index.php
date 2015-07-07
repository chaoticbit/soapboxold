<?php
session_start();
if (!isset($_SESSION['userid']) && !isset($_SESSION['fname'])) {
    echo '<meta http-equiv="refresh" content="0; url=login.php">';
    die();
}
include 'library.php';
dbConnect();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>SoapBox</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0 user-scalable=no">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
        <link rel="stylesheet" href="css/font-awesome.min.css" />
        <link rel="stylesheet" href="css/main.css" />
        <link rel="stylesheet" href="css/index.css" />        
        <link rel="stylesheet" href="css/grids.css" />
        <link rel="stylesheet" href="css/grids-responsive.css" />
        <link rel="stylesheet" href="css/responsive.css" />
        <link rel="stylesheet" href="css/medium-editor.css" />
    </head>
    <body>
        <?php include 'sidebar.php'; ?>
        <div class="container">
        <?php include 'headbar.php'; ?>
            <div class="thread-container">
                <div class="flt-left thread-parent">
                    <div class="pure-g">
                        <div class="editor-wrapper">
                            <div class="loadingstat"></div>
                            <div class="boundary">
                                <div class="thread-help pure-u-1 bg-grayLighter">
                                    <i class="fa fa-info fa-fw btn-help " title="Help"></i>
                                </div>
                                <div class="image-preview">
                                    <i class="fa fa-camera btn-image"></i>
                                    <i class="fa fa-times fg-white btn-remove-img pointer"></i>
                                </div>
                                <div class="pure-u-1" style="position: relative;">
                                    <div class="thread-owner-thumb" style="background-image: url('<?php echo $_SESSION['avatar'] ?>');"></div>
                                    <p class="bold user-fullname"><?php echo $_SESSION['fname'] . ' ' . $_SESSION['lname'] ?></p>
                                </div>                                
                                <div class="pure-u-1" style="padding: 0 20px;">
                                    <input type="text" class="txt-general margin0 thread-editor-title" name="new-thread-title" tabindex="1" placeholder="Title goes here" />
                                </div>
                                <input type="file" accept="image/*" id="thread-image" class="thread-image hidden" name="file" />
                                <input type="hidden" name="filename" value="" />
                                <div class="editable" tabindex="2" data-text="Description goes here"></div>
                                <textarea class="duptarea" name="thread-description" style="display: none;"></textarea>
                            </div>
                            <div style="width:100%;margin-bottom: 5px;">
                                <div style="width: 100%;padding: 5px;letter-spacing: normal;"><p class="bold">Assign a category to target your audience.</p></div>
                                <div class="pure-u-1" style="margin-left: 3px;">
                                    <select class="margin0 new-thread-category" name="thread-category" style="width: 100%;">
                                        <?php
                                        $result1 = mysql_query('SELECT srno, name from category') or die(mysql_error());
                                        while ($row = mysql_fetch_array($result1)) {
                                            echo '<option value="' . $row['srno'] . '">' . $row['name'] . '</option>';
                                        }
                                        ?>
                                    </select>                                    
                                </div>
                            </div>
                            <div style="width:100%;letter-spacing: normal;">
                                <div style="width: 100%;padding: 5px;letter-spacing: normal;"><p class="bold">Add tags for better filtering.</p></div>
                                <div class="tag-enter-parent flt-left">
                                    <input type="text" class="tag-enter-txt" placeholder="add up to 5 optional tags"/>
                                    <input type="hidden" name="tags" class="tags" data-cnt="0" />
                                </div>                                
                            </div>
                        </div>
                        <div class="pure-u-1 threadactions" style="margin-bottom:20px;">
                            <div class="pure-g">
                                <div class="pure-u-4-5" style="display: none;">
                                    <button class="btn-general post-thread bg-cyan fg-white">POST THREAD</button>
                                </div>                                                                
                                <div class="pure-u-1">
                                    <button class="btn-general new-thread-toggle bg-cyan fg-white">CREATE YOUR THREAD</button>
                                </div>
                                <div class="pure-u-1-5 cancel-toggle" style="padding-left: 5px;display: none;">
                                    <button class="btn-general cancel-new-thread-toggle bg-gray fg-white">CANCEL</button>
                                </div>                                
                            </div>
                        </div>
<!--                        <div class="pure-u-1 bg-white thread" style="border: 0;">
                            <div class="pure-g">
                                <div class="pure-u-1 featured-thumbnail" style="background-image: url('images/himalaya.jpg');"></div>
                                <div class="pure-u-1" style="position: relative;">
                                    <div class="thread-owner-thumb" style="background-image: url('images/avatar_jitesh.jpg');">
                                    </div>
                                    <p class="bold">Jitesh Deshpande</p>
                                    <i class="fa fa-angle-down fa-fw thread-options-toggle"></i>
                                    <ul class="thread-options bg-white">
                                        <li><a href="javascript:;" onclick="hideThread();"><i class="fa fa-fw fa-minus-circle"></i> Hide This Thread</a></li>
                                        <li><a href="javascript:;" onclick="readingList();"><i class="fa fa-fw fa-book"></i> Add To Reading List</a></li>
                                        <li><a href="javascript:;" onclick="trackThread();"><i class="fa fa-binoculars fa-fw"></i> Track This Thread</a></li>
                                    </ul>
                                </div>
                                <div class="pure-u-1 thread-title" style="padding: 10px 20px 5px 20px;">
                                    <h4 class="bold margin0">Call of Duty Advanced Warfare Review</h4>
                                </div>
                                <div class="pure-u-1 thread-description">
                                    <p>After twenty years in the music industry, it’s safe to say Steve Wilson really knows how to put out one great album after the other. He fronts his band with his charismatic guitar playing and interesting song writing along with the aid of Gavin Harrison’s often amazing drumming performances. After releasing In Absentia, it was really difficult to see whether or not the band could release an eighth album that was worthy of the masterpiece that In Absentia was. However, once the subtle ambiance of the title track gives way to a ingenious guitar riff and fantastic drumming performance, it is clear that Porcupine Tree has done us no wrong when it comes to delivering a successor worthy of In Absentia.</p>
                                    <div class="gradient"></div>
                                </div>
                                <div class="pure-u-1" style="padding: 5px 20px;">
                                <?php
                                $result = mysql_query("SELECT name FROM thread_tags WHERE tid=2") or die(mysql_error());
                                while ($row = mysql_fetch_array($result)) {
                                    echo '<a class="featured-tag tagfx" href="tag.php?t=' . $row['name'] . '">' . $row['name'] . '</a>';
                                };
                                ?>
                                </div>
                                <div class="pure-u-1">
                                    <div class="pure-g">
                                        <div class="pure-u-1-3 txt-center thread-stat"><i class="fa fa-chevron-up"></i> 999 Upvotes</div>
                                        <div class="pure-u-1-3 txt-center thread-stat"><i class="fa fa-comments-o"></i> 999 Replies</div>
                                        <div class="pure-u-1-3 txt-center thread-stat">Continue Reading</div>
                                    </div>
                                </div>                                
                            </div>
                        </div>-->
                        <?php
                        $result = mysql_query("SELECT category.name, useraccounts.username, extendedinfo.avatarpath, extendedinfo.fname, extendedinfo.lname, thread.srno, thread.title, thread.description, thread.imagepath, thread.coordinates, thread.timestamp, thread.uid FROM useraccounts, extendedinfo, thread, category, category_user WHERE thread.cid=category.srno AND thread.cid = category_user.cid and category_user.uid = " . $_SESSION['userid'] . " and extendedinfo.uid = thread.uid and useraccounts.srno = thread.uid ORDER BY timestamp DESC LIMIT 10") or die(mysql_error());
                        if (mysql_num_rows($result)) {
                            while ($row = mysql_fetch_array($result)) {
                                $flag = 0;
                                $hiderequests = mysql_query("SELECT * FROM hidethread") or die(mysql_error());
                                while ($hide = mysql_fetch_array($hiderequests)) {
                                    if ($hide['tid'] == $row['srno'] && $hide['uid'] == $_SESSION['userid'])
                                        $flag = 1;
                                }
                                if ($flag) {
                                    continue;
                                }
                                $hdnT = $row['timestamp'];
                                if ($row['imagepath'] != "") {
                                echo'
                                <div class="pure-u-1 bg-white thread block-flat" style="border: 0;">
                                    <div class="pure-g">
                                        <div class="pure-u-1 featured-thumbnail" style="background-image: url(\'' . $row['imagepath'] . '\');background-position: ' . $row['coordinates'] . ';"></div>';
                                }
                                else{
                                    echo '
                                <div class="pure-u-1 bg-white thread block-flat" style="border: 0;margin-top: 30px;">
                                    <div class="pure-g">';
                                }
                                echo'
                                        <div class="pure-u-1" style="position: relative;">
                                            <div class="thread-owner-thumb" style="background-image: url(\'' . $row['avatarpath'] . '\');"></div>';
                                            if($row['uid']==$_SESSION['userid'])
                                                echo '<p class="bold thread-owner-link"><a href="profile.php?username=' . $row['username'] . '" rel="external">You</a></p>';
                                            else
                                                echo '<p class="bold thread-owner-link"><a href="profile.php?username=' . $row['username'] . '" rel="external">' . $row['fname'] . ' ' . $row['lname'] . '</a></p>';
                                            echo '<i class="fa fa-angle-down fa-fw thread-options-toggle"></i>
                                            <ul class="thread-options bg-white">
                                                <li><a href="javascript:;" onclick="hideThread(\'' . $row['srno'] . '\',\'' . $_SESSION['username'] . '\', this);"><i class="fa fa-fw fa-minus-circle"></i> Hide this thread</a></li>';
                                                $cmd = mysql_query("SELECT * FROM readinglist WHERE tid=" . $row['srno'] . " and uid = " . $_SESSION['userid']) or die(mysql_error());
                                                if (mysql_num_rows($cmd)) {
                                                    echo '<li class="bg-green fg-white">';
                                                    echo '<a href="javascript:;" onclick="rmReadingList(\'' . $row['srno'] . '\',\'' . $_SESSION['username'] . '\', this);"><i class="fa fa-fw fa-check"></i> Added to reading list</a>';
                                                    echo '</li>';
                                                } 
                                                else {
                                                    echo '<li><a href="javascript:;" onclick="readingList(\'' . $row['srno'] . '\',\'' . $_SESSION['username'] . '\', this);"><i class="fa fa-fw fa-book"></i> Add to reading list</a></li>';
                                                }
                                                $cmd = mysql_query("SELECT * FROM trackthread WHERE tid=" . $row['srno'] . " and uid = " . $_SESSION['userid']) or die(mysql_error());
                                                if (mysql_num_rows($cmd)) {
                                                    echo '<li class="bg-green fg-white">';
                                                    echo '<a href="javascript:;" onclick="rmTrackThread(\'' . $row['srno'] . '\',\'' . $_SESSION['username'] . '\', this);"><i class="fa fa-fw fa-check"></i> Tracking this thread</a>';
                                                    echo '</li>';
                                                } 
                                                else {
                                                    echo '<li><a href="javascript:;" onclick="trackThread(\'' . $row['srno'] . '\',\'' . $_SESSION['username'] . '\', this);"><i class="fa fa-binoculars fa-fw"></i> Track this thread</a></li>';
                                                }
                                                if($_SESSION['userid']==$row['uid']){
                                                    echo '<li><a href="javascript:;" onclick="deleteThread(\'' . $row['srno'] . '\',\'' . $_SESSION['username'] . '\', this);"><i class="fa fa-fw fa-trash"></i> Delete this thread</a></li>';
                                                }
                                            echo'</ul>
                                        </div>
                                        <div class="pure-u-1 thread-title" style="padding: 10px 20px 5px 20px;">
                                            <p class="bold margin0" style="font-size: 20pt;"><a href="thread.php?tid=' . $row['srno'] . '" rel="external">' . $row['title'] . '</a></p>
                                        </div>
                                        <div class="pure-u-1 thread-description">
                                        ' . $row['description'] . '
                                            <div class="gradient"></div>
                                        </div>
                                        <div class="pure-u-1" style="padding: 5px 20px;">';
                                            echo '<a class="featured-tag thread-category" href="javascript:;" title="Category Name">' . $row['name'] . '</a>';
                                        $tags = mysql_query("SELECT name FROM thread_tags WHERE tid=" . $row['srno']) or die(mysql_error());
                                        while ($tag = mysql_fetch_array($tags)) {
                                            echo '<a class="featured-tag" href="tag.php?t=' . $tag['name'] . '" rel="external" title="Tag">' . $tag['name'] . '</a>';
                                        }
                                        echo '</div>';                                            
                                        $upvotes = mysql_query("SELECT COUNT(*) AS upvotes FROM upvotes_to_thread WHERE tid=" . $row['srno']) or die(mysql_error());
                                        $upvotes = mysql_fetch_array($upvotes);
                                        $replies = mysql_query("SELECT COUNT(*) AS replies FROM reply WHERE tid=" . $row['srno']) or die(mysql_error());
                                        $replies = mysql_fetch_array($replies);
                                        echo '
                                        <div class="pure-u-1">
                                            <div class="pure-g">
                                                <div class="pure-u-1-3 txt-center thread-stat"><p class="margin0 bold"><i class="fa fa-heart"></i> '; if($upvotes['upvotes']==1) {echo $upvotes['upvotes'] . ' <span class="hidden-for-mobile">Upvote</span>';} else{echo $upvotes['upvotes'] . ' <span class="hidden-for-mobile">Upvotes</span>';} echo '</p></div>
                                                <div class="pure-u-1-3 txt-center thread-stat"><p class="margin0 bold"><i class="fa fa-comments"></i> '; if($replies['replies']==1) {echo $replies['replies'] . ' <span class="hidden-for-mobile">Reply</span>';} else {echo $replies['replies'] . ' <span class="hidden-for-mobile">Replies</span>';} echo '</p></div>';
                                                echo '<div class="pure-u-1-3 txt-center thread-stat"><p class="margin0 bold"><i class="fa fa-clock-o hidden-for-mobile"></i> <span class="t-time">' . time_elapsed_string($row['timestamp']) . '</span></p></div>
                                            </div>
                                        </div>                                
                                    </div>
                                </div>';
                            }
                            echo '<input type="hidden" value="'.$hdnT.'" id="hdnT" />
                            <div class="pure-u-1 bg-white block-flat load-more-post-box" style="margin: 0 0 20px 0;padding: 10px;">
                                <p class="margin0 txt-center"><button class="load-more-post btn-general bg-white fg-gray">LOAD MORE POSTS</button></p>
                            </div>';
                        } else {
                            echo '<div class="full-span" style="margin: 10px;"><h3 class="txt-center light">We couldn’t find any posts for you :(</h3></div>';
                        }
                        ?>
                    </div>
                </div>
                <div class="right-pane flt-right bg-white" style="width: 32%;position: relative;">
                    <div class="full-span">
                        <div class="full-span featured-tags-title">
                            <p class="margin0 bold">featured tags</p>
                        </div>
                        <div class="full-span" style="padding: 0 20px;">
                        <?php
                            $result = mysql_query("SELECT name FROM tags order by rand() limit 15") or die(mysql_error());
                            while ($row = mysql_fetch_array($result)) {
                                echo '<a class="featured-tag tagfx" href="tag.php?t=' . $row['name'] . '" rel="external">' . $row['name'] . '</a>';
                            };
                        ?>
                        </div>
                    </div>
                    <div style="width: 100%;position: absolute;bottom: 0;background: url('images/type.png') no-repeat;background-position: 50% 80%;background-size: cover;min-height: 250px;">
                        <div style="width: 100%;padding: 25px 20px;">
                            <h6 class="light">Pen and paper. Then typewriter.<br />Now Soapbox. Tell your story.</h6>
                        </div>
                    </div>                
                </div>
            </div>
            <div class="full-span bg-white footer" style="display: none;bottom: 0;padding: 13px 10px;position: fixed;-webkit-filter: drop-shadow(0px 0px 5px rgba(0,0,0,0.5));">
                <div style="position: relative;">
                    <div class="pure-g">
                        <div class="pure-u-1-2">
                            <a href="index.php" rel="external" style="display:block;padding: 0 20px;">
                                <p class="margin0 bold" style="color: #3b5988;"><i class="fa fa-fw fa-home" style="color: #3b5988;font-size: 18px;"></i> Home</p>
                            </a>
                        </div>
                        <div class="pure-u-1-2"> 
                            <a  href="javascript:;" rel="external" style="display:block;padding: 0 10px;">
                                <p class="margin0 bold" style="color: #3b5988;"><i class="fa fa-fw fa-bell" style="color: #3b5988;font-size: 18px;"></i> Notifications 
                                    <?php 
                                    if($cnt>=1){
                                        echo '<span class="bubble mobile-bubble">'.$cnt.'</span>'; 
                                    }
                                    else{
                                        echo '<span class="bubble mobile-bubble" style="display:none;">'.$cnt.'</span>'; 
                                    }
                                    ?>
                                </p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="editor-help-parent">
            <div class="bg-white editor-help-child" style="background-image: url('images/cb.png');">
                <div class="full-span bg-mauve" style="padding: 20px;position: relative;">
                    <h5 class="margin0 bold fg-white">Soapbox Editor Help</h5>
                    <i class="fa fa-times close-help"></i>
                </div>
                <div class="full-span help-slide slideone flt-left">
                    <p class="margin0">Soapbox Editor gives you a feel of control. You can decorate your thread with the most basic editing tools, on the fly. There is nothing like raw text in Soapbox Editor. Everything you do exactly looks like a live thread!</p>
                    <p class="bold">Here's a list of things you can do with this editor.</p>
                    <ul class="help-content">
                        <li>Slap a title on your thread.</li>
                        <li>Write an attractive description.</li>
                        <li>Feature a photograph on your thread.</li>
                        <li>Attach files in case you feel generous.</li>
                        <li>Categorize for better exposure.</li>
                        <li>Add tags for optimized search results.</li>
                    </ul>
                    <p class="bold">And of course,</p>
                    <ul class="help-content">
                        <li>Share knowledge!</li>
                    </ul>
                    <h6 class="next-help bold" style="margin-top: 20px;"><a href="javascript:;"><i class="fa fa-chevron-right"></i> Take a tour</a></h6>
                </div>
                <div class="full-span help-slide slidetwo flt-left">
                    <p class="bold">To apply the effects to your text, first you need to select the text.</p>
                    <div class="full-span" style="height: 91px;margin-bottom: 10px;background-image: url('images/help0.png');background-repeat: no-repeat;"></div>
                    <p class="bold">Shortcuts for Windows/Linux and Mac users.</p>
                    <ul class="help-content">
                        <li><b>Bold: </b>Ctrl+b or Cmd+b</li>
                        <li><b>Italic: </b>Ctrl+i or Cmd+i</li>
                        <li><b>Underline: </b>Ctrl+u or Cmd+u</li>
                    </ul>
                    <p class="bold">You can also insert quotes in your thread.</p>
                    <div class="full-span" style="height: 80px;width: 360px;background-image: url('images/ssquote.png');background-repeat: no-repeat;background-size: contain;"></div>
                    <h6 class="next-help-2 bold flt-right" style="display: inline-block;"><a href="javascript:;">Next <i class="fa fa-chevron-right"></i></a></h6>
                </div>                    
                <div class="full-span help-slide slidethree flt-left">
                    <p class="bold">You may add a code snippet as well!</p>
                    <div class="full-span" style="height: 150px;width: 650px;margin-bottom: 10px;background-image: url('images/sscode.png');background-repeat: no-repeat;background-size: contain;"></div>
                    <p class="bold">Use shift+enter to insert a new line in your code</p>
                    <div class="full-span" style="height: 100px;width: 650px;margin-bottom: 10px;background-image: url('images/sslist.png');background-repeat: no-repeat;background-size: contain;"></div>
                    <p class="bold">And finally, an unordered list!</p>                        
                    <h6 class="next-help-3 bold flt-right" style="display: inline-block;"><a href="javascript:;">Close</a></h6>
                </div>                    
            </div>
        </div>
        <script src="js/jquery-2.1.3.min.js"></script>
        <script src="js/medium-editor.js"></script>
        <script>
            var editor = new MediumEditor('.editable', {
                buttonLabels: 'fontawesome',
                buttons: ['bold', 'italic', 'underline', 'quote', 'anchor', 'pre', 'indent', 'unorderedlist'],
                disablePlaceholders: true,
                targetBlank: true,
                externalInteraction: true,
                imageDragging: false,
                cleanPastedHTML: false
            });
            $('.editable').on('input', function () {
                $('.duptarea').val($(this).html());
                if($('.duptarea').val() === "<p><br></p>") {
                    window.globalDraftFlag = false;
                }
                else{
                    window.globalDraftFlag = true;
                }
            });
            $('.mobile-thread-description').on('input', function(){
                if($.trim($(this).val()) === "") {
                    window.globalDraftFlag = false;
                }
                else{
                    window.globalDraftFlag = true; 
                }
            });
            $('.fa-home').closest('li').addClass('active');
        </script>
        <script src="js/index.js"></script>
        <script src="js/main.js"></script>
    </body>
</html>
