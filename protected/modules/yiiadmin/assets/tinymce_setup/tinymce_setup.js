/* Note: the "good" way to implement tinyMCE would be to create a new db field type
 *
 * details = grappelliModels.RichText(...)
 *
 * This would translate into a standard textarea with a distinctive class name
 *
 * The JS would look for that class name and if it founds it it would load
 * dynamically the js required by the editor.
 *
 * That way you can have both standards and rich textarea on the same form
 * and you don't force the programmers to fiddle with JS paths in models.
 *
 * */
//(function($){
function CustomFileBrowser(field_name, url, type, win) {
    
    var cmsURL = "/admin/filebrowser/browse/?pop=2";
    cmsURL = cmsURL + "&type=" + type;
    
    tinyMCE.activeEditor.windowManager.open({
        file: cmsURL,
        width: 980,  // Your dimensions may differ - toy around with them!
        height: 500,
        resizable: "yes",
        scrollbars: "yes",
        inline: "no",  // This parameter only has an effect if you use the inlinepopups plugin!
        close_previous: "no",
    }, {
        window: win,
        input: field_name,
        editor_id: tinyMCE.selectedInstance.editorId,
    });
    return false;
}

tinyMCE.init({

    // General
    editor_selector :   'do_tiny',
    mode :              'specific_textareas',
    theme :             'advanced',
    skin:               'grappelli',
    dialog_type:        'window',
    browsers:           'gecko,msie,safari,opera',
    editor_deselector : 'mceNoEditor',
    language:           "ru",
    relative_urls:      false,
    plugins:            'advimage,advlink,fullscreen,paste,media,searchreplace,grappelli,grappelli_contextmenu,template',
    
    // callbackss
    file_browser_callback: 'CustomFileBrowser',

    // Layout
    width:              758,
    height:             300,
    indentation:        '10px',
    object_resizing:    false,

    // Accessibility
    cleanup_on_startup:     true,
    accessibility_warnings: false,
    remove_trailing_nbsp:   true,
    fix_list_elements :     true,
    remove_script_host:     true,

    // theme_advanced
    theme_advanced_toolbar_location: "top",
    theme_advanced_toolbar_align: "left",
    theme_advanced_statusbar_location: "bottom",
    theme_advanced_buttons1: "justifyleft,justifycenter,justifyright,bold,italic,underline,|,bullist,numlist,blockquote,|,undo,redo,|,link,unlink,|,image,|,fullscreen,|,grappelli_adv",
    theme_advanced_buttons2: "search,|,pasteword,charmap,|,code,|,table,cleanup",
    theme_advanced_buttons3: "",
    theme_advanced_path: false,
    theme_advanced_blockformats: "p,h2,pre",
    theme_advanced_resizing : true,
    theme_advanced_resize_horizontal : false,
    theme_advanced_resizing_use_cookie : true,
    theme_advanced_styles: "К левому краю=text_left;По центру=text_center;К правому краю=text_right",
    
    // Adv (?)
    advlink_styles: "intern=internal;extern=external",
    advimage_update_dimensions_onchange: true,
    
    // grappelli
    grappelli_adv_hidden: false,
    grappelli_show_documentstructure: 'on',
    
    // templates
    template_templates : [
        {
            title : "2 Spalten, symmetrisch",
            src : "/grappelli/tinymce/templates/2col/",
            description : "Symmetrical 2 Columns."
        },
        {
            title : "2 Spalten, symmetrisch mit Unterteilung",
            src : "/grappelli/tinymce/templates/4col/",
            description : "Asymmetrical 2 Columns: big left, small right."
        },
    ],
    
    // elements
    valid_elements : [
        '-span[class]','-div[class]','-p[style]','a[href|target=_blank|class]','-strong/-b','-em/-i','-u','-ol',
        '-ul','-li','br','img[class|src|alt=|width|height]','-h2,-h3,-h4','-pre','-blockquote','-code','-style'
    ].join(','),
    extended_valid_elements : "iframe[src|width|height|name|align]",
    /*extended_valid_elements: [
        'iframe[src|frameborder=0|alt|title|width|height|align|name]',
        'a[name|class|href|target|title|onclick]',
        'img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name]',
        'br[clearfix]',
        '-p[class<clearfix?summary?code]',
        'h2[class<clearfix],h3[class<clearfix],h4[class<clearfix]',
        'ul[class<clearfix],ol[class<clearfix]',
        'div[class]',
        'object[align<bottom?left?middle?right?top|archive|border|class|classid'
          + "|codebase|codetype|data|declare|dir<ltr?rtl|height|hspace|id|lang|name"
          + "|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
          + "|onmouseout|onmouseover|onmouseup|standby|style|tabindex|title|type|usemap"
          + "|vspace|width]",
        'param[id|name|type|value|valuetype<DATA?OBJECT?REF]',
        'address'
    ].join(','),*/
    valid_child_elements : [
        'h1/h2/h3/h4/h5/h6/a[%itrans_na]',       'table[thead|tbody|tfoot|tr|td]',
        'strong/b/p/div/em/i/td[%itrans|#text]', 'body[%btrans|#text]'
    ].join(','),

    // custom cleanup
     setup: function(ed) {
    //     // Gets executed before DOM to HTML string serialization
    //     ed.onBeforeGetContent.add(function(ed, o) {
    //         // State get is set when contents is extracted from editor
    //         if (o.get) {
    //             // Remove empty paragraphs (because this is bad)
    //             tinymce.each(ed.dom.select('p', o.node), function(n) {
    //                 alert(n.firstChild);
    //                 ed.dom.remove(n);
    //             });
    //             // Remove douple spaces
    //             // o.content = o.content.replace(/<(strong|b)([^>]*)>/g, '');
    //         }
    //     });
    ed.onKeyDown.add(function(ed, e) {

      //define local variables
      var tinymax = 255, 
          tinylen, htmlcount;

      //manually setting our max character limit
      tinymax = ed.settings.charLimit;

      //grabbing the length of the curent editors content
      tinylen = ed.getContent().replace(/(<([^>]+)>)/ig,"").length;

      //setting up the text string that will display in the path area
      htmlcount = "HTML Character Count: " + tinylen + "/" + tinymax;

      //if the user has exceeded the max turn the path bar red.
      if (tinylen > tinymax){

        // place text string in path bar
        if ( $('.max_char_string').size() ){
          $('.max_char_string').html( '&nbsp;' + htmlcount);
        }
        else {
          $("div#"+ed.id+"_path_row").append('<span class="max_char_string">&nbsp;'+htmlcount+'</span>')
        }

        // prevent insertion of typed character
        e.preventDefault();
        e.stopPropagation();
        return false;
      }
    });
    }
        //peform this action every time a key is pressed
        
});
//}(jQuery));
