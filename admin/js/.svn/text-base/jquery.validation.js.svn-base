(function($) {
    /*
    Validation Singleton
    */
    var Validation = function() {
        
        var rules = {
            
            email : {
               check: function(value) {
                   
                   if(value)
                       return testPattern(value,".+@.+\..+");
                   return true;
               },
               msg : "Моля въведете валиден email."
            },
            date : {
               check: function(value) {
                   
                   if(value)
                       return testPattern(value,"[0-9]{1,2}\.[0-9]{1,2}\.[0-9]{4}");
                   return true;
               },
               msg : "Моля въведете валидна дата."
            },
            url : {

               check : function(value) {

                   if(value)
                       return testPattern(value,"https?://(.+\.)+.{2,4}(/.*)?");
                   return true;
               },
               msg : "Моля въведете валиден адрес."
            },
            integer : {

               check : function(value) {

                   if(value)
                       return testPattern(value,"^[0-9]+$");
                   return true;
               },
               msg : "Полето трябва да съдържа число."
            },
            decimal : {

               check : function(value) {

                   if(value)
                       return testPattern(value,"^[0-9]+(\.[0-9]{1,2})?$");
                   return true;
               },
               msg : "Полето трябва да съдържа положително десетично число с два знака след '.'"
            },
            percent : {

               check : function(value) {

                   if(value)
                       if(testPattern(value,"^[0-9]{1,2}(\.[0-9]{1,2})?$")) {
                       		if(value>=0 && value<=100) {
                       			return true;
                       		} else {
                       			return false;
                       		}
                       } else {
                       		return false;
                       }
                       
                   return true;
               },
               msg : "Полето трябва да съдържа процент (положително десетично число от 0 до 100)"
            },
            integer_to_100 : {

               check : function(value) {

                   if(value) {
                       if(testPattern(value,"^[0-9]+$")) {
                       		if(value>1 && value<100) {
                       			return true;
                       		} else {
                       			return false;
                       		}
                       } else {
                       	return false;
                       }
                   }
                   return true;
               },
               msg : "Полето трябва да съдържа цяло число до 100."
            },
            required : {
                
               check: function(value) {

                   if(value)
                       return true;
                   else
                       return false;
               },
               msg : "Полето е задължително."
            }
        }
        var testPattern = function(value, pattern) {

            var regExp = new RegExp("^"+pattern+"$","");
            return regExp.test(value);
        }
        return {
            
            addRule : function(name, rule) {

                rules[name] = rule;
            },
            getRule : function(name) {

                return rules[name];
            }
        }
    }
    
    /* 
    Form factory 
    */
    var Form = function(form) {
        
        var fields = [];
        form.find("input[validation], textarea[validation], select[validation]").each(function() {
            
            fields.push(new Field(this));
        });
        this.fields = fields;
    }
    Form.prototype = {
        validate : function() {

            for(field in this.fields) {
                
                this.fields[field].validate();
            }
        },
        isValid : function() {
            
            for(field in this.fields) {
                
                if(!this.fields[field].valid) {
            
                    this.fields[field].field.focus();
                    return false;
                }
            }
            return true;
        }
    }
    
    /* 
    Field factory 
    */
    var Field = function(field) {

        this.field = $(field);
        this.valid = false;
        this.attach("change");
    }
    Field.prototype = {
        
        attach : function(event) {
        
            var obj = this;
            if(event == "change") {
                obj.field.bind("change",function() {
                    return obj.validate();
                });
            }
            if(event == "keyup") {
                obj.field.bind("keyup",function(e) {
                    return obj.validate();
                });
            }
        },
        validate : function() {
            
            var obj = this,
                field = obj.field,
                //errorClass = "errorlist",
                //errorlist = $(document.createElement("ul")).addClass(errorClass),
                errorClass = "system negative",
                errorlist = $(document.createElement("span")).addClass(errorClass),
                types = field.attr("validation").split(" "),
                container = field.parent().parent(),
                errors = []; 
            
            field.parent().next(".negative").remove();
            for (var type in types) {

                var rule = $.Validation.getRule(types[type]);
                if(!rule.check(field.val())) {

                    container.addClass("error");
                    errors.push(rule.msg);
                }
            }
            if(errors.length) {

                obj.field.unbind("keyup")
                obj.attach("keyup");
                field.after(errorlist.empty());
                for(error in errors) {
                	container.append(errorlist);  
                	errorlist.html(errors[error]);
                }
                obj.valid = false;
                field.parent().css('border','1px solid red');
            } 
            else {
                errorlist.remove();
                container.removeClass("error");
                obj.valid = true;
                field.parent().css('border','1px solid #CECECE');
            }
        }
    }
    
    /* 
    Validation extends jQuery prototype
    */
    $.extend($.fn, {
        
        validation : function() {
            
            var validator = new Form($(this));
            $.data($(this)[0], 'validator', validator);
            
            $(this).bind("submit", function(e) {
                validator.validate();
                if(!validator.isValid()) {
                    e.preventDefault();
                }
            });
        },
        validate : function() {
            
            var validator = $.data($(this)[0], 'validator');
            validator.validate();
            return validator.isValid();
            
        }
    });
    $.Validation = new Validation();
})(jQuery);