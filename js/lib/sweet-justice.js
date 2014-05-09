/*
 * Sweet Justice: beautiful justified text.
 *
 * Include this file at the bottom of your pages
 * and it will hyphenate and justify your text.
 * The script pays attention to elements with
 * any of these three CSS classes:
 *
 *   sweet-justice:  Hyphenated and justified
 *   sweet-hypens:   Hyphenation only
 *   justice-denied: No hypens or justification.
 *                   This is useful for child nodes.
 *
 * Hyphenation is accomplished by inserting soft
 * hyphen characters (0x00AD) into long words.
 *
 * Requires either jQuery or YUI3.
 *
 * BSD license: Share and enjoy.
 * @author carlos@bueno.org 23 April 2010
 * github.com/aristus/sweet-justice
 *
 */

var justify_element;


!function() {

  // don't break up short words.
  var MIN_WORD = 3;

  // don't mess with the content of these tags.
  var tag_blacklist = {
    'code': true,
    'pre': true,
    'abbr': true
  }

  // Recurse raw DOM nodes, hyphenating each text node.
  function justify_my_love(el) {
    var nodes = el.childNodes;
    for (var i=0; i<nodes.length; i++) {
      var node = nodes[i];

      switch (node.nodeType) {
        case 3: // Node.TEXT_NODE
          node.nodeValue = break_dance(node.nodeValue);
          break;

        case 1: // Node.ELEMENT_NODE
          if (!tag_blacklist[node.nodeName.toLowerCase()] &&
              node.className.indexOf('justice-denied') === -1) {
            justify_my_love(node);
          }
          break;
      }
    }
  }

  // Given a plain-text string, insert shy-phens into long words.
  // Variant of the VCCV algorithm
  // http://www.bramstein.com/projects/typeset/
  // http://defoe.sourceforge.net/folio/knuth-plass.html
  // If you are a student of English grammar or typography, this
  // will make you cry. If you read anything other than English,
  // this will also make you cry.
  var whitespace = /[ \s\n\r\v\t]+/;
  function break_dance(text) {
    var words = text.split(whitespace);
    for (var i=0; i<words.length; i++) {
      if (breakable(words[i])) {
        words[i] = break_word_tr(words[i]);
      }
    }
    return words.join(' ');
  }

  // determine whether a word is good for hyphenation.
  // no numbers, email addresses, hyphens, or &entities;
  function breakable(word) {
    return (/\w{3,}/.test(word)) && (!/^[0-9\&]|@|\-|\u00AD/.test(word));
  }

  // Detect all Unicode vowels. Just last week I told someone
  // to never do this. Never say never, I guess. The Closure
  // compiler transforms this into ASCII-safe \u0000 encoding.
  // http://closure-compiler.appspot.com/home
  var vowels = 'aeiouAEIOU'+
    'ẚÁáÀàĂăẮắẰằẴẵẲẳÂâẤấẦầẪẫẨẩǍǎÅåǺǻÄäǞǟÃãȦȧǠǡĄąĀāẢảȀȁȂȃẠạẶặẬậḀḁȺⱥ'+
    'ǼǽǢǣÉƏƎǝéÈèĔĕÊêẾếỀềỄễỂểĚěËëẼẽĖėȨȩḜḝĘęĒēḖḗḔḕẺẻȄȅȆȇẸẹỆệḘḙḚḛɆɇɚɝÍíÌìĬĭÎîǏǐÏ'+
    'ïḮḯĨĩİiĮįĪīỈỉȈȉȊȋỊịḬḭIıƗɨÓóÒòŎŏÔôỐốỒồỖỗỔổǑǒÖöȪȫŐőÕõṌṍṎṏȬȭȮȯȰȱØøǾǿǪǫǬǭŌōṒṓ'+
    'ṐṑỎỏȌȍȎȏƠơỚớỜờỠỡỞởỢợỌọỘộƟɵÚúÙùŬŭÛûǓǔŮůÜüǗǘǛǜǙǚǕǖŰűŨũṸṹŪūṺṻỦủȔȕȖȗƯưỨứỪừ'+
    'ỮữỬửỰựỤụṲṳṶṷṴṵɄʉ';
  var vowels_array=vowels.split('');
  var c = '[^'+vowels+']';
  var v = '['+vowels+']';
  var vccv = new RegExp('('+v+c+')('+c+v+')', 'g');
  var simple = new RegExp('(.{2,4}'+v+')'+'('+c+')', 'g');
  var presuf = /^(\W*)(anti|auto|ab|an|ax|bi|contra|cat|cath|cum|cog|col|com|con|cor|could|co|desk|de|dis|did|dif|di|eas|every|ever|extra|ex|end|epi|evi|func|fund|hyst|hy|just|jus|loc|lig|lit|li|mech|manu|man|mal|mis|mid|mono|multi|micro|non|nano|ob|oc|of|opt|op|over|para|per|post|pre|peo|pro|retro|rea|re|rhy|should|some|semi|sen|sol|sub|suc|suf|super|sup|sur|sus|syn|sym|syl|tech|trans|tri|typo|type|uni|un|van|vert|with|would|won)?(.*?)(weens?|widths?|icals?|ables?|ings?|tions?|ions?|ies|isms?|ists?|ful|ness|ments?|ly|ify|ize|ity|en|ers?|ences?|tures?|ples?|als?|phy|puts?|phies|ry|ries|cy|cies|mums?|ous|cents?)?(\W*)$/i;

  // "algorithmic" hyphenation
  var dumb = /\u00AD(.?)|$\u00AD(.{0,2}\w+)$/;
  function break_word_default(word) {
    return word
      .replace(vccv, '$1\u00AD$2')
      .replace(simple, '$1\u00AD$2')
      .replace(dumb, '$1');
  }
  function isVowel(c) {
    return vowels_array.indexOf(c) !== -1
  }

  function hasVowel(word){
    
    var a = word.split('');
    for (key in a) {
        if (a.hasOwnProperty(key)  &&        // These are explained
            /^0$|^[1-9]\d*$/.test(key) &&    // and then hidden
            key <= 4294967294                // away below
            ) {
            if(isVowel(a[key]) ) return true;
        }
    }
  }

  function findLastVowelPos(word){
    
    var a = word.split('');
    var last=0;

    for (key in a) {
        if (a.hasOwnProperty(key)  &&        // These are explained
            /^0$|^[1-9]\d*$/.test(key) &&    // and then hidden
            key <= 4294967294                // away below
            ) {
            if(isVowel(a[key]) ) last=key;
        }
    }
    return last;

  }

  // dictionary-based hypenation similar to the original
  // TeX algo: split on well-known prefixes and suffixes
  // then along the vccv line. This is not i18n nor even
  // generally correct, but is fairly compact.
  

  function subbrake(word){
    if(!hasVowel(word) || word.length<3 ) {
      return [word];
    }

    var lastVowelPosition = findLastVowelPos(word);
    var result=[];

    //console.log('SesliVar :' + word + " son sesli position:" +lastVowelPosition );

    /* en sagdaki sesli harfin solundaki harf sesli ise o zaman
    bu en sagdaki sesliden heceyi ayir */
    if(lastVowelPosition==0 || isVowel(word.split('')[lastVowelPosition-1]) ){
      result[0]=word.substring(0,lastVowelPosition);
      result[1]=word.substring(lastVowelPosition,word.length) ;
    }
    else 
    /* en sagdaki seslinin solundaki harf sessiz ise 
    o zaman heceyi bu sessizden ayir*/
    {
      result[0]=word.substring(0,lastVowelPosition-1) ;
      result[1]=word.substring(lastVowelPosition-1,word.length) ;
    }
    return result;

  }


  Array.prototype.remove = function() {
    var what, a = arguments, L = a.length, ax;
    while (L && this.length) {
        what = a[--L];
        while ((ax = this.indexOf(what)) !== -1) {
            this.splice(ax, 1);
        }
    }
    return this;
  };

  function break_word_tr(word) {
    

    word=word.trim();

    var orjWord=word;

    var wordParts=[];
    while (true) {
      var newParts = subbrake(word);
      if(newParts.length==1){
        wordParts.push (newParts[0]);
        break;
      } else {
        word=word.substring(0,newParts[0].length);
        //wordParts.push (newParts[1]);
        
        wordParts.push (newParts[1]);
      }
    }
    wordParts.remove("");
    //console.log(wordParts);
    var result= wordParts.reverse().join('\u00AD'); 

    return result;
  }

  function break_word_en(word) {
    // punctuation, prefix, center, suffix, punctuation
    var parts = presuf.exec(word);
    var ret = [];
    if (parts[2]) {
      ret.push(parts[2]);
    }
    if (parts[3]) {
      ret.push(parts[3].replace(vccv, '$1\u00AD$2'));
    }
    if (parts[4]) {
      ret.push(parts[4]);
    }
    return (parts[1]||'') + ret.join('\u00AD') + (parts[5]||'');
  }

  // The shy-phen character is an odd duck. On copy/paste
  // most apps other than browsers treat them as printable
  // instead of a hyphenation hint, which is usually not what
  // you want. So on copy we take 'em out. The selection APIs
  // are very different across browsers so there is a lot of
  // browser-specific jazzhands in this function. The basic
  // idea is to grab the data being copied, make a "shadow"
  // element of it, remove the shy-phens, select and copy
  // that, then reinstate the original selection.
  //
  // More than you ever wanted to know:
  // http://www.cs.tut.fi/~jkorpela/shy.html
  function copy_protect(e) {
    var body = document.getElementsByTagName('body')[0];
    var shyphen = /(?:\u00AD|\&#173;|\&shy;)/g;
    var shadow = document.createElement('div');
    shadow.style.overflow = 'hidden';
    shadow.style.position = 'absolute';
    shadow.style.top = '-5000px';
    shadow.style.height = '1px';
    body.appendChild(shadow);

    // FF3, WebKit
    if (typeof window.getSelection !== 'undefined') {
      sel = window.getSelection();
      var range = sel.getRangeAt(0);
      shadow.appendChild(range.cloneContents());
      shadow.innerHTML = shadow.innerHTML.replace(shyphen, '');
      sel.selectAllChildren(shadow);
      window.setTimeout(function() {
        shadow.parentNode.removeChild(shadow);
        if (typeof window.getSelection().setBaseAndExtent !== 'undefined') {
          sel.setBaseAndExtent(
            range.startContainer,
            range.startOffset,
            range.endContainer,
            range.endOffset
          );
        }
      },0);

    // Internet Explorer
    } else {
      sel = document.selection;
      var range = sel.createRange();
      shadow.innerHTML = range.htmlText.replace(shyphen, '');
      var range2 = body.createTextRange();
      range2.moveToElementText(shadow);
      range2.select();
      window.setTimeout(function() {
        shadow.parentNode.removeChild(shadow);
        if (range.text !== '') {
          range.select();
        }
      },0);
    }
    return;
  }

  // jQuery

 function sweet_justice_jq() {
    justify_element = justify_my_love;
  }


  // Insert class styles. More mindless browser-banging. *sigh*
  try {
    var style = document.createElement('style');
    style.type = 'text/css';
    var css = '.sweet-justice {text-align:justify;text-justify:distribute} ' +
              '.justice-denied {text-align:left;text-justify:normal}';
    if(!!(window.attachEvent && !window.opera)) {
      style.styleSheet.cssText = css;
    } else {
      style.appendChild(document.createTextNode(css));
    }
    document.getElementsByTagName('head')[0].appendChild(style);
  } catch (e) {
    // we did our best...
  }

  // dispatch on library
  if (window.jQuery) {
    
    $().ready(sweet_justice_jq);
    
  } 
}();
