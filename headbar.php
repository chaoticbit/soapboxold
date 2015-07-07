<div class="headbar-mobile">
    <i class="fa fa-navicon fa-fw fg-white flt-left toggle-stack"></i>
    <input type="text" class="search-mobile" placeholder="Search" />
    <i class="fa fa-times-circle fa-fw fg-white flt-right cancel-text"></i>
    <i class="fa fa-edit fa-fw fg-white flt-left toggle-new-question"></i>
    <span class="toggle-cancel-search">Cancel</span>
</div>
<div class="headbar">
    <input type="text" class="search light" placeholder="SEARCH" />
</div>
<div class="filler"></div>
<div class="search-container">
    <div class="search-actions pure-g">
        <input type="hidden" name="search-option" value="2" /> <!-- 2: search-all , 1:search-users , 0:search-tags -->
        <div class="search-switch-parent pure-u-1-4">
            <span>Search All</span>
            <span class="search-switch search-all">
                <small></small>
            </span>
        </div>
        <div class="search-switch-parent pure-u-1-4">
            <span>Search Users</span>
            <span class="search-switch search-user uncheck-search-switch">
                <small></small>
            </span>
        </div>
        <div class="search-switch-parent pure-u-1-4">
            <span>Search Tags</span>
            <span class="search-switch search-tags uncheck-search-switch">
                <small></small>
            </span>
        </div>
        <select class="margin0 pure-u-1-4 search-category">
            <option value="">Select Category</option>
            <?php
            $result_ = mysql_query('SELECT srno, name from category') or die(mysql_error());
            while ($row = mysql_fetch_array($result_)) {
                echo '<option value="' . $row['srno'] . '">' . $row['name'] . '</option>';
            }
            ?>
        </select>
    </div>
    <div class="pure-g thread-result-set inner-search-container">
        <!--                    <div class="pure-u-17-24">
                                <div class="pure-g">
                                    <div class="pure-u-1" style = "padding: 10px 10px 10px 0;"><p class = "margin0 bold" style = "text-transform: uppercase;font-size: small;letter-spacing: 2px;">threads</p></div>
                                    <ul class="pure-u-1">
                                        <li class="thread-search-li full-span" style="padding: 10px;border-bottom: 1px solid #eae9ed;">
                                            <a href="javascript:;" style="display: block;">
                                                <div class="pure-g">
                                                    <div class="pure-u-1-12">
                                                        <div class="flt-left result-thumb-pic" style="width: 50px;height: 50px;margin-top: 3px;border-radius: 50%;background: url('images/avatar_mihir.jpg') no-repeat;background-position: 50% 50%;background-size: cover;">
        
                                                        </div>
                                                    </div>
                                                    <div class="pure-u-11-12" style="padding-left: 5px;">
                                                        <h5 class="margin0">Even after eight studio albums</h5>
                                                        <div class="pure-g">
                                                            <div class="pure-u-1-5" style="padding: 5px 0 0 0;">
                                                                <p class="margin0"><i class="fa fa-chevron-up fa-fw"></i> 999 Upvotes</p>
                                                            </div>
                                                            <div class="pure-u-1-5" style="padding: 5px 0 0 0;">
                                                                <p class="margin0"><i class="fa fa-comments-o fa-fw"></i> 999 Replies</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>-->
        <!--                    <div class="pure-u-7-24">
                                <div class="pure-u-1">
                                    
                                </div>
                                <div class="pure-u-1">
                                    
                                </div>
                            </div>-->
    </div>
    <!--
                    <div class="inner-search-container full-span">
                        
                    </div>-->
</div>
<div class="search-container-mobile">
    <!--                <div class="full-span featured-tags-title">
                        <p class="margin0 bold">threads</p>
                    </div>
                    <ul>
                        <li>
                            <a href="javascript:;">
                                <div class="flt-left mobile-search-thumb" style="background-image: url('images/avatar_mihir.jpg') "></div>
                                <p class="flt-left margin0 bold">I love programming!</p>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                <div class="flt-left mobile-search-thumb" style="background-image: url('images/avatar_atharva.jpg') "></div>
                                <p class="margin0 bold">I love programming!</p>
                            </a>
                        </li>                    
                    </ul>
                    <div class="full-span featured-tags-title">
                        <p class="margin0 bold">users</p>
                    </div>
                    <ul>
                        <li>
                            <a href="javascript:;">
                                <div class="flt-left mobile-search-thumb" style="background-image: url('images/avatar_mihir.jpg') "></div>
                                <p class="margin0 bold">Mihir Karandikar</p>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                <div class="flt-left mobile-search-thumb" style="background-image: url('images/avatar_atharva.jpg') "></div>
                                <p class="margin0 bold">Atharva Dandekar</p>
                            </a>
                        </li>                    
                    </ul>
                    <div class="full-span featured-tags-title">
                        <p class="margin0 bold">tags</p>
                    </div>
                    <div class="flt-left">
                        <a href="javascript:;" class="featured-tag">Books</a>
                        <a href="javascript:;" class="featured-tag">Books</a>
                        <a href="javascript:;" class="featured-tag">Books</a>
                    </div>-->
</div>
<div class="mobile-new-thread-container">
    <div class="txt-center flt-left" style="width:100%;height:50px;border-bottom:1px solid #ccc;padding:15px 10px;">
        <button class="cancel-new-thread fg-lightBlue flt-left bold btn-general" style="letter-spacing: 1px;font-size: 14px;width: auto;border: 0;padding: 5px 0px 5px 3px;">CANCEL</button>
        <span class="txt-center bold " style="  vertical-align: sub;">NEW THREAD</span>
        <button class="post-thread-mobile fg-lightBlue flt-right bold btn-general" style="letter-spacing: 1px;width: auto;font-size: 14px;border: 0;padding: 5px 0px 5px 3px;">POST</button>
    </div>
    <div class="loadingstatmobile"></div>
    <div class="flt-left" style="padding: 10px;width: 100%;">
        <div class="pure-u-1" style="padding: 7px;border-bottom: 1px solid rgba(0,0,0,0.1);">
            <i class="fa fa-camera mobile-file-upload-toggle fa-fw fa-2x pointer flt-left"></i>
            <span class="mobile-filename-span" style="vertical-align: middle;"> Upload Image</span>
            <i class="fa fa-times-circle btn-remove-img-mobile fa-fw fa-2x pointer flt-right" style="display: none;"></i>
        </div>
        <div class="pure-u-1">
            <input type="text" class="txt-general mobile-thread-title" placeholder="Title goes here" />
        </div>
        <div class="pure-u-1">
            <textarea class="mobile-thread-description" placeholder="Description goes here"></textarea>
        </div>
        <input type="file" accept="image/*" name="filemobile" class="thread-mobile-image hidden" />
        <input type="hidden" name="mobile-filename" />
        <select class="margin0 mobile-thread-category" name="mobile-thread-category" style="width: 100%;">
            <?php
            $result1 = mysql_query('SELECT srno, name from category') or die(mysql_error());
            while ($row = mysql_fetch_array($result1)) {
                echo '<option value="' . $row['srno'] . '">' . $row['name'] . '</option>';
            }
            ?>
        </select> 
        <div style="width:100%;letter-spacing: normal;">
            <div class="mobile-tag-enter-parent flt-left ">
                <input type="text" class="mobile-tag-enter-txt" placeholder="add a tag"/>
                <input type="hidden" name="mobiletags" class="mobiletags" data-cnt="0" />
            </div>                                
        </div>
    </div>
</div>
