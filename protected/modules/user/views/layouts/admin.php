<!DOCTYPE html>
<html lang="en">
<head>        
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <!--[if gt IE 8]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <![endif]-->        
    
    <title>Users List - Virgo Premium Admin Template</title>
    
    <link href="css/stylesheets.css" rel="stylesheet" type="text/css" />      
    <!--[if lt IE 10]>
        <link href="css/ie.css" rel="stylesheet" type="text/css" />
    <![endif]-->        
    <link rel="icon" type="image/ico" href="favicon.ico"/>
    
    <script type='text/javascript' src='js/plugins/jquery/jquery-1.8.3.min.js'></script>
    <script type='text/javascript' src='js/plugins/jquery/jquery-ui-1.9.1.custom.min.js'></script>
    <script type='text/javascript' src='js/plugins/jquery/globalize.js'></script>
    <script type='text/javascript' src='js/plugins/other/excanvas.js'></script>
    
    <script type='text/javascript' src='js/plugins/other/jquery.mousewheel.min.js'></script>
        
    <script type='text/javascript' src='js/plugins/bootstrap/bootstrap.min.js'></script>            
    
    <script type='text/javascript' src='js/plugins/cookies/jquery.cookies.2.2.0.min.js'></script>
    
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
    
    <script type='text/javascript' src='js/plugins/fancybox/jquery.fancybox.pack.js'></script>
    
    <script type='text/javascript' src='js/plugins/jflot/jquery.flot.js'></script>    
    <script type='text/javascript' src='js/plugins/jflot/jquery.flot.stack.js'></script>    
    <script type='text/javascript' src='js/plugins/jflot/jquery.flot.pie.js'></script>
    <script type='text/javascript' src='js/plugins/jflot/jquery.flot.resize.js'></script>
    
    <script type='text/javascript' src='js/plugins/epiechart/jquery.easy-pie-chart.js'></script>
    <script type='text/javascript' src='js/plugins/knob/jquery.knob.js'></script>
        
    <script type='text/javascript' src='js/plugins/sparklines/jquery.sparkline.min.js'></script>    
    
    <script type='text/javascript' src='js/plugins/pnotify/jquery.pnotify.min.js'></script>
    
    <script type='text/javascript' src='js/plugins/fullcalendar/fullcalendar.min.js'></script>        
    
    <script type='text/javascript' src='js/plugins/datatables/jquery.dataTables.min.js'></script>    
    
    <script type='text/javascript' src='js/plugins/wookmark/jquery.wookmark.js'></script>        
    
    <script type='text/javascript' src='js/plugins/jbreadcrumb/jquery.jBreadCrumb.1.1.js'></script>
    
    <script type='text/javascript' src='js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js'></script>
    
    <script type='text/javascript' src="js/plugins/uniform/jquery.uniform.min.js"></script>
    <script type='text/javascript' src="js/plugins/select/select2.min.js"></script>
    <script type='text/javascript' src='js/plugins/tagsinput/jquery.tagsinput.min.js'></script>
    <script type='text/javascript' src='js/plugins/maskedinput/jquery.maskedinput-1.3.min.js'></script>
    <script type='text/javascript' src='js/plugins/multiselect/jquery.multi-select.min.js'></script>    
    
    <script type='text/javascript' src='js/plugins/validationEngine/languages/jquery.validationEngine-en.js'></script>
    <script type='text/javascript' src='js/plugins/validationEngine/jquery.validationEngine.js'></script>        
    <script type='text/javascript' src='js/plugins/stepywizard/jquery.stepy.js'></script>
        
    <script type='text/javascript' src='js/plugins/animatedprogressbar/animated_progressbar.js'></script>
    <script type='text/javascript' src='js/plugins/hoverintent/jquery.hoverIntent.minified.js'></script>
    
    <script type='text/javascript' src='js/plugins/media/mediaelement-and-player.min.js'></script>    
    
    <script type='text/javascript' src='js/plugins/cleditor/jquery.cleditor.js'></script>
    
    <script type='text/javascript' src='js/plugins/shbrush/XRegExp.js'></script>
    <script type='text/javascript' src='js/plugins/shbrush/shCore.js'></script>
    <script type='text/javascript' src='js/plugins/shbrush/shBrushXml.js'></script>
    <script type='text/javascript' src='js/plugins/shbrush/shBrushJScript.js'></script>
    <script type='text/javascript' src='js/plugins/shbrush/shBrushCss.js'></script>    
    
    <script type='text/javascript' src='js/plugins/filetree/jqueryFileTree.js'></script>        
        
    <script type='text/javascript' src='js/plugins/slidernav/slidernav-min.js'></script>    
    <script type='text/javascript' src='js/plugins/isotope/jquery.isotope.min.js'></script>    
    <script type='text/javascript' src='js/plugins/jnotes/jquery-notes_1.0.8_min.js'></script>
    <script type='text/javascript' src='js/plugins/jcrop/jquery.Jcrop.min.js'></script>
    <script type='text/javascript' src='js/plugins/ibutton/jquery.ibutton.min.js'></script>
        
    <script type='text/javascript' src='js/plugins.js'></script>
    <script type='text/javascript' src='js/charts.js'></script>
    <script type='text/javascript' src='js/actions.js'></script>
    
</head>
<body>
    
    <div class="header">
        <a href="index.html" class="logo"></a>
        
        <div class="buttons">
            <div class="popup" id="subNavControll">
                <div class="label"><span class="icos-list"></span></div>
            </div>
            <div class="dropdown">
                <div class="label"><span class="icos-user2"></span></div>
                <div class="body" style="width: 160px;">
                    <div class="itemLink">
                        <a href="#"><span class="icon-cog icon-white"></span> Settings</a>
                    </div>
                    <div class="itemLink">
                        <a href="#"><span class="icon-comment icon-white"></span> Messages</a>
                    </div>                    
                    <div class="itemLink">
                        <a href="#"><span class="icon-off icon-white"></span> Logoff</a>
                    </div>                                        
                </div>                
            </div>            
            <div class="popup">
                <div class="label"><span class="icos-search1"></span></div>
                <div class="body">
                    <div class="arrow"></div>
                    <div class="row-fluid">
                        <div class="row-form">
                            <div class="span12">                    
                                <div class="input-append input-prepend">
                                    <span class="add-on"><i class="icon-search"></i></span>                                    
                                    <input type="text" name="search" placeholder="Keyword..."/>
                                    <button class="btn" type="button">Search</button>
                                </div>                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="popup">
                <div class="label"><span class="icos-cog"></span></div>
                <div class="body">
                    <div class="arrow"></div>
                    <div class="row-fluid">
                        <div class="row-form">
                            <div class="span12">
                                <span class="top">Themes:</span>
                                <div class="themes">
                                    <a href="#" data-theme="" class="tip" title="Default"><img src="img/themes/default.jpg"/></a>                                    
                                    <a href="#" data-theme="ssDaB" class="tip" title="DaB"><img src="img/themes/dab.jpg"/></a>
                                    <a href="#" data-theme="ssTq" class="tip" title="Tq"><img src="img/themes/tq.jpg"/></a>
                                    <a href="#" data-theme="ssGy" class="tip" title="Gy"><img src="img/themes/gy.jpg"/></a>
                                    <a href="#" data-theme="ssLight" class="tip" title="Light"><img src="img/themes/light.jpg"/></a>
                                    <a href="#" data-theme="ssDark" class="tip" title="Dark"><img src="img/themes/dark.jpg"/></a>
                                    <a href="#" data-theme="ssGreen" class="tip" title="Green"><img src="img/themes/green.jpg"/></a>
                                    <a href="#" data-theme="ssRed" class="tip" title="Red"><img src="img/themes/red.jpg"/></a>
                                </div>
                            </div>
                        </div>
                        <div class="row-form">
                            <div class="span12">
                                <span class="top">Backgrounds:</span>
                                <div class="backgrounds">
                                    <a href="#" data-background="bg_default" class="bg_default"></a>
                                    <a href="#" data-background="bg_mgrid" class="bg_mgrid"></a>
                                    <a href="#" data-background="bg_crosshatch" class="bg_crosshatch"></a>
                                    <a href="#" data-background="bg_hatch" class="bg_hatch"></a>                                    
                                    <a href="#" data-background="bg_light_gray" class="bg_light_gray"></a>
                                    <a href="#" data-background="bg_dark_gray" class="bg_dark_gray"></a>
                                    <a href="#" data-background="bg_texture" class="bg_texture"></a>
                                    <a href="#" data-background="bg_light_orange" class="bg_light_orange"></a>
                                    <a href="#" data-background="bg_yellow_hatch" class="bg_yellow_hatch"></a>                        
                                    <a href="#" data-background="bg_green_hatch" class="bg_green_hatch"></a>                        
                                </div>
                            </div>          
                        </div>
                        <div class="row-form">
                            <div class="span12">
                                <span class="top">Navigation:</span>
                                <input type="radio" name="navigation" id="fixedNav"/> Fixed 
                                <input type="radio" name="navigation" id="collapsedNav"/> Collapsible
                                <input type="radio" name="navigation" id="hiddenNav"/> Hidden
                            </div>                                
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        
    </div>
    
    <div class="navigation">

        <ul class="main">
            <li><a href="index.html"><span class="icom-screen"></span><span class="text">Main</span></a></li>
            <li><a href="#ui"><span class="icom-bookmark"></span><span class="text">UI elements</span></a></li>
            <li><a href="#forms"><span class="icom-pencil3"></span><span class="text">Forms stuff</span></a></li>
            <li><a href="#tables"><span class="icom-newspaper"></span><span class="text">Tables</span></a></li>
            <li><a href="#media"><span class="icom-videos"></span><span class="text">Media & Files</span></a></li>            
            <li><a href="#stats"><span class="icom-stats-up"></span><span class="text">Statistic</span></a></li>
            <li><a href="typography.html"><span class="icom-clipboard1"></span><span class="text">Typography</span></a></li>
            <li><a href="#samples" class="active"><span class="icom-box-add"></span><span class="text">Samples</span></a></li>
            <li><a href="#other"><span class="icom-star1"></span><span class="text">Other</span></a></li>            
        </ul>
        
        <div class="control"></div>        
        
        <div class="submain">                                 
            
            <div id="default">
                
                <div class="widget-fluid userInfo clearfix">
                    <div class="image">
                        <img src="img/examples/users/dmitry.jpg" class="img-polaroid"/>
                    </div>              
                    <div class="name">Welcom, Dmitry</div>
                    <ul class="menuList">
                        <li><a href="#"><span class="icon-cog"></span> Settings</a></li>
                        <li><a href="#"><span class="icon-comment"></span> Messages</a></li>
                        <li><a href="#"><span class="icon-share-alt"></span> Logoff</a></li>                        
                    </ul>
                    <div class="text">
                        Welcom back! Your last visit: 24.10.2012 in 19:55
                    </div>
                </div>
                
                <div class="widget-fluid TAC">
                    <div class="kchart">
                        <input type="text" class="knob" data-min="1" data-max="100" value="35" data-width="90" data-height="90" data-fgColor="#b84b48" data-readOnly="true" data-bgColor="#f7f8fa"/>
                        <div class="label label-important">Free Space</div>
                    </div>                    
                    <div class="kchart">
                        <input type="text" class="knob" data-min="1" data-max="3000" value="1982" data-width="90" data-height="90" data-fgColor="#f89406" data-readOnly="true" data-bgColor="#f7f8fa"/>
                        <div class="label label-warning">Visits</div>
                    </div>                                                      
                </div>                
                <div class="dr"><span></span></div>
                <div class="widget">
                    <button class="btn btn-primary btn-block">Button block</button>
                </div>                
                <div class="widget">
                    <button class="btn btn-warning btn-block">Some another button</button>
                </div>
                <div class="dr"><span></span></div>
                <ul class="fmenu">
                    <li>
                        <a href="#">Submenu level 2</a>                        
                    </li>
                    <li>
                        <a href="#">Submenu level 2</a>
                        <span class="caption dark">5</span>
                        <ul>
                            <li><a href="#">Submenu level 3</a><span class="caption">1</span></li>
                            <li><a href="#">Submenu level 3</a><span class="caption red">2</span></li>
                            <li><a href="#">Submenu level 3</a><span class="caption green">3</span></li>
                            <li><a href="#">Submenu level 3</a><span class="caption orange">4</span></li>
                            <li><a href="#">Submenu level 3</a><span class="caption purple">5</span></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">Submenu level 2</a>                        
                    </li>                    
                </ul>                
                <div class="dr"><span></span></div>
                <div class="menu">
                    <a href="#">Submenu 1</a>
                    <a href="#">Submenu 2</a>
                    <a href="#">Submenu 3</a>
                    <a href="#">Submenu 4</a>
                    <a href="#">Submenu 5</a>
                </div>
                <div class="dr"><span></span></div>
            </div>          
            
            <div id="ui">
                
                <div class="menu">
                    <a href="ui.html"><span class="icon-user"></span> Interface</a>
                    <a href="buttons.html"><span class="icon-chevron-right"></span> Buttons set</a>
                    <a href="widgets.html"><span class="icon-th-large"></span> Widgets</a>                    
                    <a href="icons.html"><span class="icon-fire"></span> Icons</a>
                    <a href="grid.html"><span class="icon-th"></span> Grid system</a>
                    <a href="dnd.html"><span class="icon-move"></span> Drug and drop</a>
                </div>                                           
                
                <div class="dr"><span></span></div>                
                <div class="widget">
                    <button class="btn btn-primary btn-block">Button block</button>
                </div>                
                <div class="dr"><span></span></div>
                <div class="widget-fluid">
                    <div class="accordion">
                        <h3>Section 1</h3>
                        <div>
                            <p>Mauris mauris ante, blandit et, ultrices a, suscipit eget, quam. Integer ut neque. Vivamus nisi metus, molestie vel, gravida in, condimentum sit amet, nunc. Nam a nibh. Donec suscipit eros. Nam mi. Proin viverra leo ut odio. Curabitur malesuada. Vestibulum a velit eu ante scelerisque vulputate.</p>
                        </div>
                        <h3>Section 2</h3>
                        <div>
                            <p>Sed non urna. Donec et ante. Phasellus eu ligula. Vestibulum sit amet purus. Vivamus hendrerit, dolor at aliquet laoreet, mauris turpis porttitor velit, faucibus interdum tellus libero ac justo. Vivamus non quam. In suscipit faucibus urna.</p>
                        </div>
                        <h3>Section 3</h3>
                        <div>
                            <ul>
                                <li>List item one</li>
                                <li>List item two</li>
                                <li>List item three</li>
                            </ul>                                
                            <p>Nam enim risus, molestie et, porta ac, aliquam ac, risus. Quisque lobortis. Phasellus pellentesque purus in massa. Aenean in pede. Phasellus ac libero ac tellus pellentesque semper. Sed ac felis. Sed commodo, magna quis lacinia ornare, quam ante aliquam nisi, eu iaculis leo purus venenatis dui.</p>
                        </div>                            
                    </div>                
                </div>
                <div class="dr"><span></span></div>
                <div class="widget">
                    <span>Default:</span>
                    <div class="progress small progress-info">
                        <div class="bar tip" style="width: 30%;" data-original-title="30%"></div>
                    </div>                                
                    <span>Success:</span>
                    <div class="progress small progress-success">
                        <div class="bar tip" style="width: 50%;" data-original-title="50%"></div>
                    </div>
                    <span>Warning:</span>
                    <div class="progress small progress-warning">
                        <div class="bar tip" style="width: 70%;" data-original-title="70%"></div>
                    </div>       
                    <span>Danger:</span>
                    <div class="progress small progress-danger">
                        <div class="bar tip" style="width: 90%;" data-original-title="90%"></div>
                    </div>                                 
                </div>
                <div class="dr"><span></span></div>
                
            </div>
            
            <div id="forms">
                                                
                <div class="menu">
                    <a href="forms.html"><span class="icon-align-justify"></span> Form elements</a>
                    <a href="validation.html"><span class="icon-ok-sign"></span> Form validation</a>
                    <a href="wizard.html"><span class="icon-share"></span> Wizard</a>  
                    <a href="form_grid.html"><span class="icon-th"></span> Form grid system</a>
                    <a href="editor.html"><span class="icon-pencil"></span> Editors</a>
                    <a href="edit_image.html"><span class="icon-picture"></span> Image handling</a>
                </div>                                                
                
                <div class="dr"><span></span></div>
                <div class="widget-fluid">
                    <div class="row-form">
                        <span>Text:</span>
                        <input type="text" placeholder="Placeholder example"/>
                    </div>
                    <div class="row-form">
                        <input type="checkbox" checked="checked" value="1"/>Checked 
                        <input type="checkbox" value="2"/>Unchecked                         
                    </div>                    
                    <div class="row-form">                        
                        <select>
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                        </select>
                    </div>                    
                    <div class="row-form">
                        <span>Tags</span>
                        <input class="tags" value="PHP,CSS"/>
                    </div>
                    <div class="row-form">                        
                        <textarea name="text"></textarea>
                    </div>                    
                    <div class="row-form TAR">
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </div>
                <div class="dr"><span></span></div>  
                
            </div>                        

            <div id="tables">
                                                
                <div class="menu">
                    <a href="tables.html"><span class="icon-align-justify"></span> Default tables</a>
                    <a href="dynamic_tables.html"><span class="icon-ok-sign"></span> Dynamic tables</a>                          
                </div>                                                
                
                <div class="dr"><span></span></div>                
                <div class="widget-fluid">
                    <table cellpadding="0" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th width="30">ID</th>
                                <th>User</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>u-231</td>
                                <td><a href="#">Dmitry Ivaniuk</a></td>
                            </tr>
                            <tr>
                                <td>u-250</td>
                                <td><a href="#">Helen Symonchuk</a></td>
                            </tr>
                            <tr>
                                <td>u-256</td>
                                <td><a href="#">Olga Yukhimchuk</a></td>
                            </tr>                            
                            <tr>
                                <td>u-276</td>
                                <td><a href="#">Valentin Ratushev</a></td>
                            </tr>                                                        
                        </tbody>
                    </table>                    
                </div>
                <div class="dr"><span></span></div>                
                <div class="widget-fluid">
                    <table cellpadding="0" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th><input type="checkbox" class="checkall"/></th>
                                <th width="25%">ID</th>
                                <th width="75%">User</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="checkbox" name="ch[]"/></td>
                                <td>u-231</td>
                                <td><a href="#">Dmitry Ivaniuk</a></td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" name="ch[]"/></td>
                                <td>u-250</td>
                                <td><a href="#">Helen Symonchuk</a></td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" name="ch[]"/></td>
                                <td>u-256</td>
                                <td><a href="#">Olga Yukhimchuk</a></td>
                            </tr>                            
                            <tr>
                                <td><input type="checkbox" name="ch[]"/></td>
                                <td>u-276</td>
                                <td><a href="#">Valentin Ratushev</a></td>
                            </tr>                                                        
                        </tbody>
                    </table>                    
                </div>  
                <div class="dr"><span></span></div>
                
            </div>              
            
            <div id="media">
                
                <div class="menu">
                    <a href="images.html"><span class="icon-picture"></span> Images</a>
                    <a href="videos.html"><span class="icon-film"></span> Videos</a>
                    <a href="files.html"><span class="icon-file"></span> File handling</a>                                                                           
                </div>               
                <div class="dr"><span></span></div>
                <div class="widget-fluid">
                    <div class="head">File Tree</div>
                    <div id="fileTree"></div>
                </div>
                <div class="dr"><span></span></div>                
                
            </div>                          
            
            <div id="stats">
                
                <div class="menu">
                    <a href="charts.html"><span class="icon-signal"></span> Charts</a>                    
                    <a href="chart_widgets.html"><span class="icon-star"></span> Chart widgets</a>      
                </div>                
                <div class="dr"><span></span></div>
                <div class="widget-fluid TAC">
                    <div class="kchart">
                        <input type="text" class="knob" data-min="1" data-max="100" value="85" data-width="90" data-height="90" data-fgColor="#b84b48" data-readOnly="true" data-bgColor="#f7f8fa"/>
                        <div class="label label-important">Server load</div>
                    </div>                    
                    <div class="kchart">
                        <input type="text" class="knob" data-min="1" data-max="1024" value="256" data-width="90" data-height="90" data-fgColor="#f89406" data-readOnly="true" data-bgColor="#f7f8fa"/>
                        <div class="label label-warning">Used RAM</div>
                    </div>                              
                </div>
                <div class="dr"><span></span></div>
                <div class="widget-fluid">
                    <div class="row-fluid">
                        <div class="span6 TAC">
                            <span class="mChartBar" sparkWidth="100" sparkHeight="30" sparkLineColor="#3f506a" sparkFillColor="#f7f8fa">1:3,2:4,3:3,3:4,4:2</span>
                        </div>
                        <div class="span6 TAC">
                            <span class="mChartBar" sparkWidth="100" sparkHeight="30" sparkType="bar" sparkBarColor="#b84b48">5,6,4,6,5,4,5,6,8,5,6</span>
                        </div>
                    </div>
                </div>
                <div class="widget-fluid">    
                    <div class="row-fluid">
                        <div class="span6 TAC">
                            <span class="mChartBar" sparkWidth="100" sparkHeight="30" sparkType="discrete" sparkLineColor="#f89406">5,6,4,6,5,4,5,6,8,5,6</span>
                        </div>
                        <div class="span6 TAC">
                            <span class="mChartBar" sparkType="bullet" sparkWidth="100" sparkHeight="30" sparkPerformanceColor="#3f506a" sparkTargetColor="#b84b48">10,12,12,9,7</span>
                        </div>
                    </div>                                        
                </div>
                <div class="dr"><span></span></div>                
            </div>              
            
            <div id="samples">
                <div class="menu">
                    <a href="profile.html"><span class="icon-user"></span> User profile</a>
                    <a href="stream.html"><span class="icon-refresh"></span> Stream activity</a>
                    <a href="mailbox.html"><span class="icon-envelope"></span> Mailbox</a> 
                    <a href="invoice.html"><span class="icon-list-alt"></span> Invoice</a>
                    <a href="gallery.html"><span class="icon-picture"></span> Gallery</a>
                    <a href="users.html" class="active"><span class="icon-align-justify"></span> Users list</a>
                    <a href="contacts.html"><span class="icon-book"></span> Contacts list</a>
                    <a href="faq.html"><span class="icon-question-sign"></span> FAQ</a>
                </div>
            </div>

            <div id="other">
                <div class="menu">
                    <a href="login.html"><span class="icon-off"></span> Login page</a>
                    <a href="error_403.html"><span class="icon-warning-sign"></span> Error 403 Forbidden</a>
                    <a href="error_404.html"><span class="icon-warning-sign"></span> Error 404 Not found</a>
                    <a href="error_503.html"><span class="icon-warning-sign"></span> Error 503 Service Unavailable</a>                
                </div>
                
                <div class="widget">
                    <div class="alert alert-block">                
                        <strong>Alert block!</strong> Click me!:P
                    </div>
                    <div class="alert alert-error">            
                        <strong>Oh snap!</strong> Change a few... 
                    </div>
                    <div class="alert alert-success">            
                        <strong>Well done!</strong> Successfully...
                    </div>            
                    <div class="alert alert-info">            
                        <strong>Heads up!</strong> This alert...
                    </div>                  
                </div>
            </div>         
                                    
        </div>

    </div>
    
    <div class="breadCrumb clearfix">    
        <ul id="breadcrumbs">
            <li><a href="index.html">Home</a></li>
            <li><a href="#">Sample pages</a></li>
            <li>Users list</li>
        </ul>        
    </div>
    
    <div class="content">
        <?php echo $content; ?>
    </div>  

    
</body>
</html>
