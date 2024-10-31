;(function ($) {
    $(document).ready(function(){
        setTimeout(function(){
            $(".mgs-pefe-particles").each(function(){
                let $id         = $(this).attr("id"),
                    $number     = $(this).data("number"),
                    $shapes     = $(this).data("shapes"),
                    $size       = $(this).data("size"),
                    $sizeRandom = $(this).data("size-random"),
                    $dir        = $(this).data("dir"),
                    $ll         = $(this).data("line-linked"),
                    $llColor    = $(this).data("line-linked-color"),
                    $color      = $(this).data("color");

                particlesJS($id,{
                    "particles": {
                        "retina_detect": true,
                        "number"       : {
                            "value": parseInt( $number )
                        },
                        "shape"        : {
                            "type": $shapes
                        },
                        "size"         : {
                            "value" : $size,
                            "random": ( $sizeRandom === "yes" ) ? true: false,
                        },
                        "color"        : {
                            "value" : $color,
                        },
                        "move"         : {
                            "enable"   : true,
                            "speed"    : 1,
                            "direction": $dir,
                            "random"   : false,
                            "straight" : false,
                            "out_mode" : "out",
                        },
                        "line_linked"  : {
                            "enable"  : ( $ll === "yes" ) ? true : false,
                            "distance": 150,
                            "color"   : $llColor,
                            "opacity" : 0.4,
                            "width"   : 2
                        },
                    }
                });
            });
        }, 500);
    });
})(jQuery);