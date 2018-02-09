layui.use(['form','layer','jquery'],function(){
    var form = layui.form,
        layer = parent.layer === undefined ? layui.layer : top.layer
        $ = layui.jquery;

    $(".loginBody .seraph").click(function(){
        layer.msg("这只是做个样式，至于功能，你见过哪个后台能这样登录的？还是老老实实的找管理员去注册吧",{
            time:5000
        });
    })

    //登录按钮
    form.on("submit(login)",function(data){
        $(this).text("登录中...").attr("disabled","disabled").addClass("layui-disabled");
        var userName = $("#username").val();
        var passWord = $("#password").val();
        var api_url = "api.php";
        if (api_path) {
            api_url = api_path+api_url;
        }
        $.ajax({
            type: "POST",
            url: api_url,
            dataType: "json",
            data: "m=1&userName="+userName+"&passWord="+passWord,
            success: function(msg){
               if (msg.status == 2) {
                    layer.msg(msg.info,{
                        time:5000
                    });  
               } else {
                    layer.msg("登录成功",{
                        time:5000
                    });
               }
               $('.layui-btn').text("登录").removeAttr("disabled").removeClass("layui-disabled");
            }
       }); 
        return false;
    })

    //表单输入效果
    $(".loginBody .input-item").click(function(e){
        e.stopPropagation();
        $(this).addClass("layui-input-focus").find(".layui-input").focus();
    })
    $(".loginBody .layui-form-item .layui-input").focus(function(){
        $(this).parent().addClass("layui-input-focus");
    })
    $(".loginBody .layui-form-item .layui-input").blur(function(){
        $(this).parent().removeClass("layui-input-focus");
        if($(this).val() != ''){
            $(this).parent().addClass("layui-input-active");
        }else{
            $(this).parent().removeClass("layui-input-active");
        }
    })
})
