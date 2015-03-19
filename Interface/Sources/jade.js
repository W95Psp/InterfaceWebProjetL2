var jade = require('jade');
var jadephp = require('jade4php');
var fs = require('fs');

jadephp(jade);

function treat(path){
  var compiled = jade.render(fs.readFileSync(path).toString(), {
    pretty: '\t',
    filename: path
  });
  if(compiled.length>0)
    fs.writeFileSync(path.substr(0, path.length-4)+'php', compiled);
}

function lookFor(dir){
  fs.readdirSync(dir).forEach(function(item){
    if(fs.statSync(dir+'/'+item).isDirectory())
      lookFor(dir+'/'+item);
    else if(item.search(/\.jade$/)!=-1)
      treat(dir+'/'+item);
  });
}

lookFor('./');