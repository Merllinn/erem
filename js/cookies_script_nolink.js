/*
 CookieConsent v2.7.0-rc3
 https://www.github.com/orestbida/cookieconsent
 Author Orest Bida
 Released under the MIT License
*/
(function(){var Ta=function(Ma){var f={current_lang:"en",auto_language:null,autorun:!0,cookie_name:"cc_cookie",cookie_expiration:182,cookie_domain:window.location.hostname,cookie_path:"/",cookie_same_site:"Lax",use_rfc_cookie:!1,autoclear_cookies:!0,revision:0,script_selector:"data-cookiecategory"},k={},u={},S=!1,T=!1,ea=!1,qa=!1,fa=!1,v,V,y,ra,sa,W=!0,ta=!1,E=null,Ea=!1,ma,ua,va=[],aa=[],N=[],L=[],wa=[],ba=document.documentElement,M,x,H,O,Na=function(a){"number"===typeof a.cookie_expiration&&(f.cookie_expiration=
a.cookie_expiration);"boolean"===typeof a.autorun&&(f.autorun=a.autorun);"string"===typeof a.cookie_domain&&(f.cookie_domain=a.cookie_domain);"string"===typeof a.cookie_same_site&&(f.cookie_same_site=a.cookie_same_site);"string"===typeof a.cookie_path&&(f.cookie_path=a.cookie_path);"string"===typeof a.cookie_name&&(f.cookie_name=a.cookie_name);"function"===typeof a.onAccept&&(ra=a.onAccept);"function"===typeof a.onChange&&(sa=a.onChange);"number"===typeof a.revision&&(-1<a.revision&&(f.revision=a.revision),
ta=!0);!0===a.autoclear_cookies&&(f.autoclear_cookies=!0);!0===a.use_rfc_cookie&&(f.use_rfc_cookie=!0);!0===a.hide_from_bots&&(Ea=navigator&&(navigator.userAgent&&/bot|crawl|spider|slurp|teoma/i.test(navigator.userAgent)||navigator.webdriver));f.page_scripts=!0===a.page_scripts;f.page_scripts_order=!1!==a.page_scripts_order;"browser"===a.auto_language||!0===a.auto_language?f.auto_language="browser":"document"===a.auto_language&&(f.auto_language="document");var b=a.languages;a=a.current_lang;"browser"===
f.auto_language?(a=navigator.language||navigator.browserLanguage,2<a.length&&(a=a[0]+a[1]),a=a.toLowerCase(),b=xa(a,b)):b="document"===f.auto_language?xa(document.documentElement.lang,b):"string"===typeof a?f.current_lang=xa(a,b):f.current_lang;f.current_lang=b},Oa=function(){for(var a=document.querySelectorAll('a[data-cc="c-settings"], button[data-cc="c-settings"]'),b=0;b<a.length;b++)a[b].setAttribute("aria-haspopup","dialog"),I(a[b],"click",function(c){k.showSettings(0);c.preventDefault?c.preventDefault():
c.returnValue=!1})},xa=function(a,b){if(Object.prototype.hasOwnProperty.call(b,a))return a;if(0<ha(b).length)return Object.prototype.hasOwnProperty.call(b,f.current_lang)?f.current_lang:ha(b)[0]},Fa=function(){function a(c,d){var e=!1,h=!1;try{for(var l=c.querySelectorAll(b.join(':not([tabindex="-1"]), ')),m,n=l.length,p=0;p<n;)m=l[p].getAttribute("data-focus"),h||"1"!==m?"0"===m&&(e=l[p],h||"0"===l[p+1].getAttribute("data-focus")||(h=l[p+1])):h=l[p],p++}catch(r){return c.querySelectorAll(b.join(", "))}d[0]=
l[0];d[1]=l[l.length-1];d[2]=e;d[3]=h}var b=["[href]","button","input","details",'[tabindex="0"]'];a(O,aa);S&&a(x,va)},ya,za,Ga="",ia,Pa=function(a,b){M=g("div");M.id="cc--main";M.style.position="fixed";M.style.zIndex="1000000";M.innerHTML='\x3c!--[if lt IE 9 ]><div id="cc_div" class="cc_div ie"></div><![endif]--\x3e\x3c!--[if (gt IE 8)|!(IE)]>\x3c!--\x3e<div id="cc_div" class="cc_div"></div>\x3c!--<![endif]--\x3e';var c=M.children[0],d=f.current_lang,e="string"===typeof ba.textContent?"textContent":
"innerText";ya=b;za=function(z){!0===z.force_consent&&J(ba,"force--consent");var P=z.languages[d].consent_modal.description;ta&&(P=W?P.replace("{{revision_message}}",""):P.replace("{{revision_message}}",Ga||z.languages[d].consent_modal.revision_message||""));if(x)ia.innerHTML=P;else{x=g("div");var X=g("div"),na=g("div"),ja=g("div");ia=g("div");var oa=g("div"),ka=g("button"),ca=g("button"),pa=g("div");x.id="cm";X.id="c-inr";na.id="c-inr-i";ja.id="c-ttl";ia.id="c-txt";oa.id="c-bns";ka.id="c-p-bn";ca.id=
"c-s-bn";pa.id="cm-ov";ka.className="c-bn";ca.className="c-bn c_link";ja.setAttribute("role","heading");ja.setAttribute("aria-level","2");x.setAttribute("role","dialog");x.setAttribute("aria-modal","true");x.setAttribute("aria-hidden","false");x.setAttribute("aria-labelledby","c-ttl");x.setAttribute("aria-describedby","c-txt");x.style.visibility=pa.style.visibility="hidden";pa.style.opacity=0;ja.insertAdjacentHTML("beforeend",z.languages[d].consent_modal.title);ia.insertAdjacentHTML("beforeend",P);
ka[e]=z.languages[d].consent_modal.primary_btn.text;ca[e]=z.languages[d].consent_modal.secondary_btn.text;var Ha;"accept_all"===z.languages[d].consent_modal.primary_btn.role&&(Ha="all");I(ka,"click",function(){k.hide();k.accept(Ha)});"accept_necessary"===z.languages[d].consent_modal.secondary_btn.role?I(ca,"click",function(){k.hide();k.accept([])}):I(ca,"click",function(){k.showSettings(0)});na.appendChild(ja);na.appendChild(ia);oa.appendChild(ka);oa.appendChild(ca);X.appendChild(na);X.appendChild(oa);
x.appendChild(X);c.appendChild(x);c.appendChild(pa);S=!0}};a||za(b);H=g("div");var h=g("div"),l=g("div"),m=g("div");O=g("div");var n=g("div"),p=g("div"),r=g("button"),U=g("div"),Q=g("div"),A=g("div");H.id="s-cnt";h.id="c-vln";m.id="c-s-in";l.id="cs";n.id="s-ttl";O.id="s-inr";p.id="s-hdr";Q.id="s-bl";r.id="s-c-bn";A.id="cs-ov";U.id="s-c-bnc";r.className="c-bn";r.setAttribute("aria-label",b.languages[d].settings_modal.close_btn_label||"Close");H.setAttribute("role","dialog");H.setAttribute("aria-modal",
"true");H.setAttribute("aria-hidden","true");H.setAttribute("aria-labelledby","s-ttl");n.setAttribute("role","heading");H.style.visibility=A.style.visibility="hidden";A.style.opacity=0;U.appendChild(r);I(h,"keydown",function(z){z=z||window.event;27===z.keyCode&&k.hideSettings(0)},!0);I(r,"click",function(){k.hideSettings(0)});y=b.languages[f.current_lang].settings_modal.blocks;V=b.languages[f.current_lang].settings_modal.cookie_table_headers;r=y.length;n.insertAdjacentHTML("beforeend",b.languages[f.current_lang].settings_modal.title);
for(var q=0;q<r;++q){var w=g("div"),B=g("div"),t=g("div"),F=g("div");w.className="c-bl";B.className="desc";t.className="p";F.className="title";t.insertAdjacentHTML("beforeend",y[q].description);if("undefined"!==typeof y[q].toggle){var C="c-ac-"+q,Y=g("button"),G=g("label"),D=g("input"),R=g("span"),Z=g("span"),da=g("span"),Ia=g("span");Y.className="b-tl";G.className="b-tg";D.className="c-tgl";da.className="on-i";Ia.className="off-i";R.className="c-tg";Z.className="t-lb";Y.setAttribute("aria-expanded",
"false");Y.setAttribute("aria-controls",C);D.type="checkbox";R.setAttribute("aria-hidden","true");var Aa=y[q].toggle.value;D.value=Aa;Z[e]=y[q].title;Y.insertAdjacentHTML("beforeend",y[q].title);F.appendChild(Y);R.appendChild(da);R.appendChild(Ia);a?-1<K(u.level,Aa)?(D.checked=!0,N.push(!0)):N.push(!1):y[q].toggle.enabled?(D.checked=!0,N.push(!0)):N.push(!1);L.push(Aa);y[q].toggle.readonly?(D.disabled=!0,J(R,"c-ro"),wa.push(!0)):wa.push(!1);J(B,"b-acc");J(F,"b-bn");J(w,"b-ex");B.id=C;B.setAttribute("aria-hidden",
"true");G.appendChild(D);G.appendChild(R);G.appendChild(Z);F.appendChild(G);(function(z,P,X){I(Y,"click",function(){Ja(P,"act")?(Ba(P,"act"),X.setAttribute("aria-expanded","false"),z.setAttribute("aria-hidden","true")):(J(P,"act"),X.setAttribute("aria-expanded","true"),z.setAttribute("aria-hidden","false"))},!1)})(B,w,Y)}else C=g("div"),C.className="b-tl",C.setAttribute("role","heading"),C.setAttribute("aria-level","3"),C.insertAdjacentHTML("beforeend",y[q].title),F.appendChild(C);w.appendChild(F);
B.appendChild(t);if(!0!==b.remove_cookie_tables&&"undefined"!==typeof y[q].cookie_table){C=document.createDocumentFragment();for(G=0;G<V.length;++G)D=g("th"),t=V[G],D.setAttribute("scope","col"),t&&(F=t&&ha(t)[0],D[e]=V[G][F],C.appendChild(D));t=g("tr");t.appendChild(C);F=g("thead");F.appendChild(t);C=g("table");C.appendChild(F);G=document.createDocumentFragment();for(D=0;D<y[q].cookie_table.length;D++){R=g("tr");for(Z=0;Z<V.length;++Z)if(t=V[Z])F=ha(t)[0],da=g("td"),da.insertAdjacentHTML("beforeend",
y[q].cookie_table[D][F]),da.setAttribute("data-column",t[F]),R.appendChild(da);G.appendChild(R)}t=g("tbody");t.appendChild(G);C.appendChild(t);B.appendChild(C)}w.appendChild(B);Q.appendChild(w)}a=g("div");r=g("button");q=g("button");a.id="s-bns";r.id="s-sv-bn";q.id="s-all-bn";r.className="c-bn";q.className="c-bn";r.insertAdjacentHTML("beforeend",b.languages[f.current_lang].settings_modal.save_settings_btn);q.insertAdjacentHTML("beforeend",b.languages[f.current_lang].settings_modal.accept_all_btn);
a.appendChild(q);if(b=b.languages[f.current_lang].settings_modal.reject_all_btn)w=g("button"),w.id="s-rall-bn",w.className="c-bn",w.insertAdjacentHTML("beforeend",b),I(w,"click",function(){k.hideSettings();k.hide();k.accept([])}),O.className="bns-t",a.appendChild(w);a.appendChild(r);I(r,"click",function(){k.hideSettings();k.hide();k.accept()});I(q,"click",function(){k.hideSettings();k.hide();k.accept("all")});p.appendChild(n);p.appendChild(U);O.appendChild(p);O.appendChild(Q);O.appendChild(a);m.appendChild(O);
l.appendChild(m);h.appendChild(l);H.appendChild(h);c.appendChild(H);c.appendChild(A);(Ma||document.body).appendChild(M)},Qa=function(a){var b=document.querySelectorAll(".c-tgl")||[],c=[],d=!1;if(0<b.length){for(var e=0;e<b.length;e++)-1!==K(a,L[e])?(b[e].checked=!0,N[e]||(c.push(L[e]),N[e]=!0)):(b[e].checked=!1,N[e]&&(c.push(L[e]),N[e]=!1));if(f.autoclear_cookies&&T&&0<c.length){b=y.length;e=-1;var h=la("","all"),l=[f.cookie_domain,"."+f.cookie_domain];if("www."===f.cookie_domain.slice(0,4)){var m=
f.cookie_domain.substr(4);l.push(m);l.push("."+m)}for(m=0;m<b;m++){var n=y[m];if(Object.prototype.hasOwnProperty.call(n,"toggle")&&!N[++e]&&Object.prototype.hasOwnProperty.call(n,"cookie_table")&&-1<K(c,n.toggle.value)){var p=n.cookie_table,r=ha(V[0])[0],U=p.length;"on_disable"===n.toggle.reload&&(d=!0);for(var Q=0;Q<U;Q++){var A=p[Q],q=[],w=A[r],B=A.is_regex||!1,t=A.domain||null;A=A.path||!1;t&&(l=[t,"."+t]);if(B)for(B=0;B<h.length;B++)h[B].match(w)&&q.push(h[B]);else w=K(h,w),-1<w&&q.push(h[w]);
0<q.length&&(Ka(q,A,l),"on_clear"===n.toggle.reload&&(d=!0))}}}}}u={level:a,revision:f.revision,data:E,rfc_cookie:f.use_rfc_cookie};if(!T||0<c.length||!W)W=!0,Ca(f.cookie_name,JSON.stringify(u)),Da();if("function"===typeof ra&&!T)return T=!0,ra(u);"function"===typeof sa&&0<c.length&&sa(u,c);d&&window.location.reload()},Ra=function(a,b){if("string"!==typeof a||""===a||document.getElementById("cc--style"))b();else{var c=g("style");c.id="cc--style";var d=new XMLHttpRequest;d.onreadystatechange=function(){4===
this.readyState&&200===this.status&&(c.setAttribute("type","text/css"),c.styleSheet?c.styleSheet.cssText=this.responseText:c.appendChild(document.createTextNode(this.responseText)),document.getElementsByTagName("head")[0].appendChild(c),b())};d.open("GET",a);d.send()}},K=function(a,b){for(var c=a.length,d=0;d<c;d++)if(a[d]===b)return d;return-1},g=function(a){var b=document.createElement(a);"button"===a&&b.setAttribute("type",a);return b},Sa=function(){var a=!1,b=!1;I(document,"keydown",function(c){c=
c||window.event;"Tab"===c.key&&(v&&(c.shiftKey?document.activeElement===v[0]&&(v[1].focus(),c.preventDefault()):document.activeElement===v[1]&&(v[0].focus(),c.preventDefault()),b||fa||(b=!0,!a&&c.preventDefault(),c.shiftKey?v[3]?v[2]?v[2].focus():v[0].focus():v[1].focus():v[3]?v[3].focus():v[0].focus())),!b&&(a=!0))});document.contains&&I(M,"click",function(c){c=c||window.event;qa?O.contains(c.target)?fa=!0:(k.hideSettings(0),fa=!1):ea&&x.contains(c.target)&&(fa=!0)},!0)},La=function(a,b){function c(e,
h,l,m,n,p,r){p=p&&p.split(" ")||[];if(-1<K(h,n)&&(J(e,n),("bar"!==n||"middle"!==p[0])&&-1<K(l,p[0])))for(h=0;h<p.length;h++)J(e,p[h]);-1<K(m,r)&&J(e,r)}if("object"===typeof a){var d=a.consent_modal;a=a.settings_modal;S&&d&&c(x,["box","bar","cloud"],["top","middle","bottom"],["zoom","slide"],d.layout,d.position,d.transition);!b&&a&&c(H,["bar"],["left","right"],["zoom","slide"],a.layout,a.position,a.transition)}};k.allowedCategory=function(a){return-1<K(JSON.parse(la(f.cookie_name,"one",!0)||"{}").level||
[],a)};k.run=function(a){if(!document.getElementById("cc_div")&&(Na(a),!Ea&&(u=JSON.parse(la(f.cookie_name,"one",!0)||"{}"),T=void 0!==u.level,E=void 0!==u.data?u.data:null,W="number"===typeof a.revision?T?-1<a.revision?u.revision===f.revision:!0:!0:!0,S=!T||!W,Pa(!S,a),Ra(a.theme_css,function(){Fa();La(a.gui_options);Oa();f.autorun&&S&&k.show(a.delay||0);setTimeout(function(){J(M,"c--anim")},30);setTimeout(function(){Sa()},100)}),T&&W))){var b="boolean"===typeof u.rfc_cookie;if(!b||b&&u.rfc_cookie!==
f.use_rfc_cookie)u.rfc_cookie=f.use_rfc_cookie,Ca(f.cookie_name,JSON.stringify(u));Da();if("function"===typeof a.onAccept)a.onAccept(u)}};k.showSettings=function(a){setTimeout(function(){J(ba,"show--settings");H.setAttribute("aria-hidden","false");qa=!0;setTimeout(function(){ea?ua=document.activeElement:ma=document.activeElement;0!==aa.length&&(aa[3]?aa[3].focus():aa[0].focus(),v=aa)},200)},0<a?a:0)};var Da=function(){if(f.page_scripts){var a=document.querySelectorAll("script["+f.script_selector+
"]"),b=f.page_scripts_order,c=u.level||[],d=function(e,h){if(h<e.length){var l=e[h],m=l.getAttribute(f.script_selector);if(-1<K(c,m)){l.type="text/javascript";l.removeAttribute(f.script_selector);m=l.getAttribute("data-src");var n=g("script");n.textContent=l.innerHTML;(function(p,r){for(var U=r.attributes,Q=U.length,A=0;A<Q;A++)r=U[A],p.setAttribute(r.nodeName,r.nodeValue)})(n,l);m?n.src=m:m=l.src;m&&(b?n.readyState?n.onreadystatechange=function(){if("loaded"===n.readyState||"complete"===n.readyState)n.onreadystatechange=
null,d(e,++h)}:n.onload=function(){n.onload=null;d(e,++h)}:m=!1);l.parentNode.replaceChild(n,l);if(m)return}d(e,++h)}};d(a,0)}};k.set=function(a,b){switch(a){case "data":a=b.value;var c=!1;if("update"===b.mode)if(E=k.get("data"),(b=typeof E===typeof a)&&"object"===typeof E){!E&&(E={});for(var d in a)E[d]!==a[d]&&(E[d]=a[d],c=!0)}else!b&&E||E===a||(E=a,c=!0);else E=a,c=!0;c&&(u.data=E,Ca(f.cookie_name,JSON.stringify(u)));return c;case "revision":return d=b.value,a=b.prompt_consent,b=b.message,M&&"number"===
typeof d&&u.revision!==d?(ta=!0,Ga=b,W=!1,f.revision=d,!0===a?(za(ya),La(ya.gui_options,!0),Fa(),k.show()):k.accept(),b=!0):b=!1,b;default:return!1}};k.get=function(a,b){return JSON.parse(la(b||f.cookie_name,"one",!0)||"{}")[a]};k.getConfig=function(a){return f[a]};k.loadScript=function(a,b,c){var d="function"===typeof b;if(document.querySelector('script[src="'+a+'"]'))d&&b();else{var e=g("script");if(c&&0<c.length)for(var h=0;h<c.length;++h)c[h]&&e.setAttribute(c[h].name,c[h].value);d&&(e.readyState?
e.onreadystatechange=function(){if("loaded"===e.readyState||"complete"===e.readyState)e.onreadystatechange=null,b()}:e.onload=b);e.src=a;(document.head?document.head:document.getElementsByTagName("head")[0]).appendChild(e)}};k.updateScripts=function(){Da()};k.show=function(a){S&&setTimeout(function(){J(ba,"show--consent");x.setAttribute("aria-hidden","false");ea=!0;setTimeout(function(){ma=document.activeElement;v=va},200)},0<a?a:0)};k.hide=function(){S&&(Ba(ba,"show--consent"),x.setAttribute("aria-hidden",
"true"),ea=!1,setTimeout(function(){ma.focus();v=null},200))};k.hideSettings=function(){Ba(ba,"show--settings");qa=!1;H.setAttribute("aria-hidden","true");setTimeout(function(){ea?(ua&&ua.focus(),v=va):(ma.focus(),v=null);fa=!1},200)};k.accept=function(a,b){a=a||void 0;var c=b||[];b=[];var d=function(){for(var h=document.querySelectorAll(".c-tgl")||[],l=[],m=0;m<h.length;m++)h[m].checked&&l.push(h[m].value);return l};if(a)if("object"===typeof a&&"number"===typeof a.length)for(var e=0;e<a.length;e++)-1!==
K(L,a[e])&&b.push(a[e]);else"string"===typeof a&&("all"===a?b=L.slice():-1!==K(L,a)&&b.push(a));else b=d();if(1<=c.length)for(e=0;e<c.length;e++)b=b.filter(function(h){return h!==c[e]});for(e=0;e<L.length;e++)!0===wa[e]&&-1===K(b,L[e])&&b.push(L[e]);Qa(b)};k.eraseCookies=function(a,b,c){var d=[];c=c?[c,"."+c]:[f.cookie_domain,"."+f.cookie_domain];if("object"===typeof a&&0<a.length)for(var e=0;e<a.length;e++)this.validCookie(a[e])&&d.push(a[e]);else this.validCookie(a)&&d.push(a);Ka(d,b,c)};var Ca=
function(a,b){b=f.use_rfc_cookie?encodeURIComponent(b):b;var c=new Date;c.setTime(c.getTime()+864E5*f.cookie_expiration);c="; expires="+c.toUTCString();a=a+"="+(b||"")+c+"; Path="+f.cookie_path+";";a+=" SameSite="+f.cookie_same_site+";";-1<window.location.hostname.indexOf(".")&&(a+=" Domain="+f.cookie_domain+";");"https:"===window.location.protocol&&(a+=" Secure;");document.cookie=a},la=function(a,b,c){var d;if("one"===b){if((d=(d=document.cookie.match("(^|;)\\s*"+a+"\\s*=\\s*([^;]+)"))?c?d.pop():
a:"")&&a===f.cookie_name){try{d=JSON.parse(d)}catch(e){try{d=JSON.parse(decodeURIComponent(d))}catch(h){d={}}}d=JSON.stringify(d)}}else if("all"===b)for(a=document.cookie.split(/;\s*/),d=[],b=0;b<a.length;b++)d.push(a[b].split("=")[0]);return d},Ka=function(a,b,c){b=b?b:"/";for(var d=0;d<a.length;d++)for(var e=0;e<c.length;e++)document.cookie=a[d]+"=; path="+b+(-1<c[e].indexOf(".")?"; domain="+c[e]:"")+"; Expires=Thu, 01 Jan 1970 00:00:01 GMT;"};k.validCookie=function(a){return""!==la(a,"one",!0)};
var I=function(a,b,c,d){a.addEventListener?!0===d?a.addEventListener(b,c,{passive:!0}):a.addEventListener(b,c,!1):a.attachEvent("on"+b,c)},ha=function(a){if("object"===typeof a){var b=[],c=0;for(b[c++]in a);return b}},J=function(a,b){a.classList?a.classList.add(b):Ja(a,b)||(a.className+=" "+b)},Ba=function(a,b){a.classList?a.classList.remove(b):a.className=a.className.replace(new RegExp("(\\s|^)"+b+"(\\s|$)")," ")},Ja=function(a,b){return a.classList?a.classList.contains(b):!!a.className.match(new RegExp("(\\s|^)"+
b+"(\\s|$)"))};return k};"function"!==typeof window.initCookieConsent&&(window.initCookieConsent=Ta)})();

// obtain cookieconsent plugin
var cc = initCookieConsent();

var cookie = '????';



// run plugin with config object
cc.run({
    // current_lang : 'cs',
    autoclear_cookies : true,                   // default: false
    cookie_name: 'cc_cookie',                   // default: 'cc_cookie'
    cookie_expiration : 365,                    // default: 182
    page_scripts: true,                         // default: false

     auto_language : 'document',                // default: null; could also be 'browser' or 'document'
    // autorun : true,                          // default: true
    // delay : 0,                               // default: 0
     force_consent: false,
    // hide_from_bots: false,                   // default: false
    // remove_cookie_tables: false              // default: false
    // cookie_domain: location.hostname,        // default: current domain
    // cookie_path: "/",                        // default: root
    // cookie_same_site: "Lax",
    // use_rfc_cookie: false,                   // default: false
    // revision: 0,                             // default: 0

    gui_options: {
        consent_modal: {
            layout: 'cloud',                    // box,cloud,bar
            position: 'bottom center',          // bottom,middle,top + left,right,center
            transition: 'slide'                 // zoom,slide
        },
        settings_modal: {
            layout: 'box',                      // box,bar
            // position: 'left',                // right,left (available only if bar layout selected)
            transition: 'zoom'                  // zoom,slide
        }
    },

    onAccept: function (cookie) {

    },

    onChange: function (cookie, changed_preferences) {

        // If analytics category's status was changed ...
        if (changed_preferences.indexOf('analytics') > -1) {

            // If analytics category is disabled ...
            if (!cc.allowedCategory('analytics')) {

                // Disable gtag ...
                console.log('disabling gtag')
                window.dataLayer = window.dataLayer || [];

                function gtag() { dataLayer.push(arguments); }

                gtag('consent', 'default', {
                    'ad_storage': 'denied',
                    'analytics_storage': 'denied'
                });
            }
        }

    },

    languages: {
        'cs': {
            consent_modal: {
                title: 'Nastaven?? cookies: Aby web z??stal tak, jak ho zn??te',
                description: 'Abyste na na??ich str??nk??ch rychle na??li to, co hled??te, u??et??ili spoustu klik??n??, pot??ebujeme od V??s souhlas se zpracov??n??m soubor?? cookies, tj. mal??ch soubor??, kter?? se ukl??daj?? ve va??em prohl????e??i.<br /><br />Podle cookies v??s na na??ich str??nk??ch pozn??me a zobraz??me v??m je tak, aby v??echno fungovalo spr??vn?? a dle va??ich preferenc??.',
                primary_btn: {
                    text: 'P??ijmout v??e',
                    role: 'accept_all'              // 'accept_selected' or 'accept_all'
                },
                secondary_btn: {
                    text: 'P??izp??sobit',
                    role: 'settings'        // 'settings' or 'accept_necessary'
                }
            },
            settings_modal: {
                title: 'Moje preference',
                save_settings_btn: 'Ulo??it nastaven??',
                accept_all_btn: 'P??ijmout v??e',
                reject_all_btn: 'Odm??tnout v??e',
                close_btn_label: 'Zav????t'/*,
                cookie_table_headers: [
                    {col1: 'Name'},
                    {col2: 'Domain'},
                    {col3: 'Expiration'},
                    {col4: 'Description'}
                ]*/,
                blocks: [
                    {
                        title: 'K ??emu slou???? cookies?',
                        description: 'Soubory cookies slou???? k zaji??t??n?? z??kladn??ch funkc?? webu a ke zlep??en?? va??eho online z????itku. Pro ka??dou kategorii si m????ete vybrat, zda se chcete p??ihl??sit/odhl??sit, kdykoli budete cht??t.'
                    }, {
                        title: 'Nezbytn?? nutn?? cookies',
                        description: 'Tyto cookies jsou nezbytn?? kv??li spr??vn??mu fungov??n??, bezpe??nosti, ????dn??mu zobrazov??n?? na po????ta??i nebo na mobilu, funguj??c??mu vypl??ov??n?? i odes??l??n?? formul?????? a podobn??. Tyto cookies nen?? mo??n?? vypnout, bez nich by na??e str??nky nefungovaly spr??vn??.',
                        toggle: {
                            value: 'necessary',
                            enabled: true,
                            readonly: true          // cookie categories with readonly=true are all treated as "necessary cookies"
                        }
                    }, {
                        title: '??innost webov??ch str??nek a anal??za',
                        description: '????m v??c lid?? m?? statistick?? cookies zapnut??, t??m l??pe m????eme na??e str??nky vyladit. T??eba tak, ??e hojn?? nav??t??vovan?? ????sti str??nek p??esuneme hned na hlavn?? str??nku a u??et????me tak hled??n?? ostatn??m n??v??t??vn??k??m. D??ky nim jsme schopni zjistit odkud k n??m lid?? p??ich??zej??, na co klikaj??, jak dlouho u n??s z??st??vaj?? apod. Zpracov??n?? statistick??ch cookies je na??im opr??vn??n??m z??jmem. Tyto cookies zpracov??v??me na z??klad?? va??eho souhlasu. Souhlas zde m????ete kdykoliv ud??lit, ??i odvolat.',
                        toggle: {
                            value: 'analytics',     // there are no default categories => you specify them
                            enabled: false,
                            readonly: false
                        }/*,
                        cookie_table: [
                            {
                                col1: '^_ga',
                                col2: 'google.com',
                                col3: '2 years',
                                col4: 'description ...',
                                is_regex: true
                            },
                            {
                                col1: '_gid',
                                col2: 'google.com',
                                col3: '1 day',
                                col4: 'description ...',
                            }
                        ]*/
                    }, {
                        title: 'Marketing a personalizace',
                        description: 'D??ky cookies t??et??ch stran v??m m????eme p??ipomenout nab??dky, kter?? jste si prohl????eli na na??ich str??nk??ch, i jinde na internetu. Kdy?? tyto cookies zak????ete, reklam bude po????d stejn??. Ov??em na v??ci, kter?? v??s nezaj??maj??. Tyto cookies zpracov??v??me na z??klad?? va??eho souhlasu. Souhlas zde m????ete kdykoliv ud??lit, ??i odvolat.',
                        toggle: {
                            value: 'targeting',
                            enabled: false,
                            readonly: false
                        }
                    }/*, {
                        title: 'More information',
                        description: 'For any queries in relation to my policy on cookies and your choices, please <a class="cc-link" href="https://orestbida.com/contact">contact me</a>.',
                    }*/
                ]
            }
        },
        'en': {
            consent_modal: {
                title: 'Cookie settings: To keep the website as you know it',
                description: 'To quickly find what you???re looking for on our website and to save you a lot of clicking, we need your consent to process cookies, these are small files that are stored in your browser. Cookies allow us to recognise you on our website and show it to you with everything working properly and according to your preferences.',
                primary_btn: {
                    text: 'Accept all',
                    role: 'accept_all'
                },
                secondary_btn: {
                    text: 'Settings',
                    role: 'settings'
                }
            },
            settings_modal: {
                title: 'My preferences',
                save_settings_btn: 'Save settings',
                accept_all_btn: 'Accept all',
                reject_all_btn: 'Reject',
                close_btn_label: 'Close',
                blocks: [
                    {
                        title: 'What are cookies for?',
                        description: 'Cookies are used to ensure the website???s basic functions and to improve your online experience. For each category, you can choose to subscribe/unsubscribe whenever you want.'
                    }, {
                        title: 'Strictly necessary cookies',
                        description: 'These cookies are necessary for correct operation, security, proper display on a computer or mobile phone, functional filling in and sending of forms and the like. These cookies can???t be turned off, our website wouldn???t work properly without them.',
                        toggle: {
                            value: 'necessary',
                            enabled: true,
                            readonly: true
                        }
                    }, {
                        title: 'Website operation and analysis',
                        description: 'The more people have statistical cookies enabled, the better we can fine-tune our website. For example, by moving the website???s frequently visited parts to the main page and therefore saving other visitors the search. Thanks to these cookies, we are able to find out how people come to us, what they click on, how long they stay with us, etc. Statistical cookies processing is our legitimate interest. We process these cookies based on your consent. You can grant or withdraw your consent here at any time.',
                        toggle: {
                            value: 'analytics',
                            enabled: false,
                            readonly: false
                        }
                    }, {
                        title: 'Marketing and personalisation',
                        description: 'Thanks to third-party cookies, we can remind you of the offers you have viewed on our website and elsewhere on the Internet. When you disable these cookies, the number of ads remain the same, but without the ads that you???re not interested in. We process these cookies based on your consent. You can grant or withdraw your consent here at any time.',
                        toggle: {
                            value: 'targeting',
                            enabled: false,
                            readonly: false
                        }
                    }
                ]
            }
        },
        'kr': {
            consent_modal: {
                title: 'Cookie settings: To keep the website as you know it',
                description: 'To quickly find what you???re looking for on our website and to save you a lot of clicking, we need your consent to process cookies, these are small files that are stored in your browser. Cookies allow us to recognise you on our website and show it to you with everything working properly and according to your preferences.',
                primary_btn: {
                    text: 'Accept all',
                    role: 'accept_all'
                },
                secondary_btn: {
                    text: 'Settings',
                    role: 'settings'
                }
            },
            settings_modal: {
                title: 'My preferences',
                save_settings_btn: 'Save settings',
                accept_all_btn: 'Accept all',
                reject_all_btn: 'Reject',
                close_btn_label: 'Close',
                blocks: [
                    {
                        title: 'What are cookies for?',
                        description: 'Cookies are used to ensure the website???s basic functions and to improve your online experience. For each category, you can choose to subscribe/unsubscribe whenever you want.'
                    }, {
                        title: 'Strictly necessary cookies',
                        description: 'These cookies are necessary for correct operation, security, proper display on a computer or mobile phone, functional filling in and sending of forms and the like. These cookies can???t be turned off, our website wouldn???t work properly without them.',
                        toggle: {
                            value: 'necessary',
                            enabled: true,
                            readonly: true
                        }
                    }, {
                        title: 'Website operation and analysis',
                        description: 'The more people have statistical cookies enabled, the better we can fine-tune our website. For example, by moving the website???s frequently visited parts to the main page and therefore saving other visitors the search. Thanks to these cookies, we are able to find out how people come to us, what they click on, how long they stay with us, etc. Statistical cookies processing is our legitimate interest. We process these cookies based on your consent. You can grant or withdraw your consent here at any time.',
                        toggle: {
                            value: 'analytics',
                            enabled: false,
                            readonly: false
                        }
                    }, {
                        title: 'Marketing and personalisation',
                        description: 'Thanks to third-party cookies, we can remind you of the offers you have viewed on our website and elsewhere on the Internet. When you disable these cookies, the number of ads remain the same, but without the ads that you???re not interested in. We process these cookies based on your consent. You can grant or withdraw your consent here at any time.',
                        toggle: {
                            value: 'targeting',
                            enabled: false,
                            readonly: false
                        }
                    }
                ]
            }
        },
        'fr': {
            consent_modal: {
                title: 'Param??tres des cookies : Pour que notre site Web reste celui que vous connaissez',
                description: 'Pour que vous puissiez trouver rapidement ce que vous cherchez sur notre site et pour que vous puissiez ??conomiser de nombreux clics, nous avons besoin de votre consentement sur le traitement des fichiers cookies. Les cookies sont des petits fichiers qui sont enregistr??s dans votre navigateur et gr??ce auxquels nous vous reconna??trons ?? chaque fois que vous reviendrez sur notre site. Le site vous sera ensuite pr??sent?? d???une mani??re telle que tout fonctionne correctement et en fonction de vos pr??f??rences.',
                primary_btn: {
                    text: 'Accepter tout',
                    role: 'accept_all'
                },
                secondary_btn: {
                    text: 'R??glages',
                    role: 'settings'
                }
            },
            settings_modal: {
                title: 'Mes pr??f??rences',
                save_settings_btn: 'Enregistrer les param??tres',
                accept_all_btn: 'Accepter tout',
                reject_all_btn: 'Rejeter',
                close_btn_label: 'Fermer',
                blocks: [
                    {
                        title: '?? quoi servent les fichiers cookies?',
                        description: 'Les fichiers cookies garantissent les fonctions de base du site Web et am??liorent votre exp??rience en ligne. Pour chacune des cat??gories, vous pourrez choisir de vous connecter/d??connecter ?? chaque fois que vous le souhaiterez.'
                    }, {
                        title: 'Les cookies qui sont indispensables',
                        description: 'Ces cookies sont indispensables au bon fonctionnement du site, ?? la s??curit??, ?? la bonne visualisation sur votre ordinateur ou votre t??l??phone portable, ?? la saisie fonctionnelle et ?? l???envoi de formulaires, etc. Ces cookies ne peuvent pas ??tre d??sactiv??s. Sans eux, notre site Web ne pourrait pas fonctionner correctement.',
                        toggle: {
                            value: 'necessary',
                            enabled: true,
                            readonly: true
                        }
                    }, {
                        title: 'Activit?? du site Web et analyse',
                        description: 'Au plus nombreuses sont les personnes qui ont activ?? leurs cookies statistiques, au mieux nous pourrons ajuster notre site. Nous pourrons ainsi par exemple d??placer les sections du site qui sont les plus fr??quemment visit??es vers la page d???accueil et r??duire ainsi le temps de recherche des autres visiteurs. Gr??ce ?? ces cookies, nous pourrons savoir d???o?? viennent les gens qui consultent notre site, sur quoi ils cliquent, combien de temps ils passent sur notre site, etc. Le traitement des cookies statistiques est un de nos int??r??ts l??gitimes. Ces cookies sont trait??s sur la base d???un consentement que vous pourrez nous donner ou retirer ?? tout moment.',
                        toggle: {
                            value: 'analytics',
                            enabled: false,
                            readonly: false
                        }
                    }, {
                        title: 'Marketing et personnalisation',
                        description: 'Gr??ce aux cookies de tiers, nous pourrons vous rem??morer les offres que vous avez consult??es pr??c??demment sur notre site et ailleurs sur l???Internet. Si vous interdisez ces cookies, vous verrez toujours autant de publicit??s, mais elles porteront sur des choses qui ne vous int??ressent pas forc??ment. Ces cookies sont trait??s sur la base d???un consentement que vous pourrez nous donner ou retirer ?? tout moment.',
                        toggle: {
                            value: 'targeting',
                            enabled: false,
                            readonly: false
                        }
                    }
                ]
            }
        },
        'se': {
            consent_modal: {
                title: 'Cookie settings: To keep the website as you know it',
                description: 'To quickly find what you???re looking for on our website and to save you a lot of clicking, we need your consent to process cookies, these are small files that are stored in your browser. Cookies allow us to recognise you on our website and show it to you with everything working properly and according to your preferences.',
                primary_btn: {
                    text: 'Accept all',
                    role: 'accept_all'
                },
                secondary_btn: {
                    text: 'Settings',
                    role: 'settings'
                }
            },
            settings_modal: {
                title: 'My preferences',
                save_settings_btn: 'Save settings',
                accept_all_btn: 'Accept all',
                reject_all_btn: 'Reject',
                close_btn_label: 'Close',
                blocks: [
                    {
                        title: 'What are cookies for?',
                        description: 'Cookies are used to ensure the website???s basic functions and to improve your online experience. For each category, you can choose to subscribe/unsubscribe whenever you want.'
                    }, {
                        title: 'Strictly necessary cookies',
                        description: 'These cookies are necessary for correct operation, security, proper display on a computer or mobile phone, functional filling in and sending of forms and the like. These cookies can???t be turned off, our website wouldn???t work properly without them.',
                        toggle: {
                            value: 'necessary',
                            enabled: true,
                            readonly: true
                        }
                    }, {
                        title: 'Website operation and analysis',
                        description: 'The more people have statistical cookies enabled, the better we can fine-tune our website. For example, by moving the website???s frequently visited parts to the main page and therefore saving other visitors the search. Thanks to these cookies, we are able to find out how people come to us, what they click on, how long they stay with us, etc. Statistical cookies processing is our legitimate interest. We process these cookies based on your consent. You can grant or withdraw your consent here at any time.',
                        toggle: {
                            value: 'analytics',
                            enabled: false,
                            readonly: false
                        }
                    }, {
                        title: 'Marketing and personalisation',
                        description: 'Thanks to third-party cookies, we can remind you of the offers you have viewed on our website and elsewhere on the Internet. When you disable these cookies, the number of ads remain the same, but without the ads that you???re not interested in. We process these cookies based on your consent. You can grant or withdraw your consent here at any time.',
                        toggle: {
                            value: 'targeting',
                            enabled: false,
                            readonly: false
                        }
                    }
                ]
            }
        },
        'fi': {
            consent_modal: {
                title: 'Cookie settings: To keep the website as you know it',
                description: 'To quickly find what you???re looking for on our website and to save you a lot of clicking, we need your consent to process cookies, these are small files that are stored in your browser. Cookies allow us to recognise you on our website and show it to you with everything working properly and according to your preferences.',
                primary_btn: {
                    text: 'Accept all',
                    role: 'accept_all'
                },
                secondary_btn: {
                    text: 'Settings',
                    role: 'settings'
                }
            },
            settings_modal: {
                title: 'My preferences',
                save_settings_btn: 'Save settings',
                accept_all_btn: 'Accept all',
                reject_all_btn: 'Reject',
                close_btn_label: 'Close',
                blocks: [
                    {
                        title: 'What are cookies for?',
                        description: 'Cookies are used to ensure the website???s basic functions and to improve your online experience. For each category, you can choose to subscribe/unsubscribe whenever you want.'
                    }, {
                        title: 'Strictly necessary cookies',
                        description: 'These cookies are necessary for correct operation, security, proper display on a computer or mobile phone, functional filling in and sending of forms and the like. These cookies can???t be turned off, our website wouldn???t work properly without them.',
                        toggle: {
                            value: 'necessary',
                            enabled: true,
                            readonly: true
                        }
                    }, {
                        title: 'Website operation and analysis',
                        description: 'The more people have statistical cookies enabled, the better we can fine-tune our website. For example, by moving the website???s frequently visited parts to the main page and therefore saving other visitors the search. Thanks to these cookies, we are able to find out how people come to us, what they click on, how long they stay with us, etc. Statistical cookies processing is our legitimate interest. We process these cookies based on your consent. You can grant or withdraw your consent here at any time.',
                        toggle: {
                            value: 'analytics',
                            enabled: false,
                            readonly: false
                        }
                    }, {
                        title: 'Marketing and personalisation',
                        description: 'Thanks to third-party cookies, we can remind you of the offers you have viewed on our website and elsewhere on the Internet. When you disable these cookies, the number of ads remain the same, but without the ads that you???re not interested in. We process these cookies based on your consent. You can grant or withdraw your consent here at any time.',
                        toggle: {
                            value: 'targeting',
                            enabled: false,
                            readonly: false
                        }
                    }
                ]
            }
        },
        'sk': {
            consent_modal: {
                title: 'Nastavenie cookies: Aby web zostal tak, ako ho pozn??te',
                description: 'Aby ste na na??ich str??nkach r??chlo na??li to, ??o h??ad??te, u??etrili ve??a kliknut??, potrebujeme od V??s s??hlas so spracovan??m s??borov cookies, tj. mal??ch s??borov, ktor?? sa ukladaj?? vo va??om prehliada??i. Pod??a cookies v??s na na??ich str??nkach spozn??me a zobraz??me v??m ich tak, aby v??etko fungovalo spr??vne a pod??a va??ich preferenci??.',
                primary_btn: {
                    text: 'Prija?? v??etko',
                    role: 'accept_all'
                },
                secondary_btn: {
                    text: 'Nastavenia',
                    role: 'settings'
                }
            },
            settings_modal: {
                title: 'Moje preferencie',
                save_settings_btn: 'Ulo??i?? nastavenia',
                accept_all_btn: 'Prija?? v??etko',
                reject_all_btn: 'Odmietnu?? v??etko',
                close_btn_label: 'Zavrie??',
                blocks: [
                    {
                        title: 'Na ??o sl????ia cookies?',
                        description: 'S??bory cookies sl????ia na zaistenie z??kladn??ch funkci?? webu a na zlep??enie v????ho online z????itku. Pre ka??d?? kateg??riu si m????ete vybra??, ??i sa chcete prihl??si??/odhl??si?? kedyko??vek budete chcie??.'
                    }, {
                        title: 'Nevyhnutne potrebn?? cookies',
                        description: 'Tieto cookies s?? nevyhnutn?? kv??li spr??vnemu fungovaniu, bezpe??nosti, riadnemu zobrazovaniu na po????ta??i alebo na mobile, funguj??cemu vyp????aniu a odosielaniu formul??rov a podobne. Tieto cookies nie je mo??n?? vypn????, bez nich by na??e str??nky nefungovali spr??vne.',
                        toggle: {
                            value: 'necessary',
                            enabled: true,
                            readonly: true
                        }
                    }, {
                        title: '??innos?? webov??ch str??nok a anal??za',
                        description: '????m viac ??ud?? m?? ??tatistick?? cookies zapnut??, t??m lep??ie m????eme na??e str??nky vyladi??. Napr??klad tak, ??e hojne nav??tevovan?? ??asti str??nok presunieme hne?? na hlavn?? str??nku a u??etr??me tak h??adanie ostatn??m n??v??tevn??kom. V??aka nim sme schopn?? zisti?? odkia?? k n??m ??udia prich??dzaj??, na ??o klikaj??, ako dlho u n??s zost??vaj?? a pod. Spracovanie ??tatistick??ch cookies je na????m opr??vnen??m z??ujmom. Tieto cookies spracov??vame na z??klade v????ho s??hlasu. S??hlas tu m????ete kedyko??vek udeli?? alebo odvola??.',
                        toggle: {
                            value: 'analytics',
                            enabled: false,
                            readonly: false
                        }
                    }, {
                        title: 'Marketing a personaliz??cia',
                        description: 'V??aka cookies tret??ch str??n v??m m????eme pripomen???? ponuky, ktor?? ste si prezerali na na??ich str??nkach aj inde na internete. Ke?? tieto cookies zak????ete, rekl??m bude st??le rovnako. Av??ak na veci, ktor?? v??s nezauj??maj??. Tieto cookies spracov??vame na z??klade v????ho s??hlasu. S??hlas tu m????ete kedyko??vek udeli?? alebo odvola??.',
                        toggle: {
                            value: 'targeting',
                            enabled: false,
                            readonly: false
                        }
                    }
                ]
            }
        },
        'pl': {
            consent_modal: {
                title: 'Ustawienia plik??w cookies: Niech twoja strona zostanie tak?? jak?? znasz',
                description: 'Aby?? zaoszcz??dzi?? wiele klikni???? i szybko znalaz?? to czego szukasz, potrzebujemy Twojej zgody na przetwarzanie plik??w cookies, Czym s?? cookies? To ma??e pliki, kt??re s?? przechowywane w Twojej przegl??darce. Na ich podstawie, rozpoznamy ci?? na naszej stronie i wy??wietlimy Ci j?? poprawnie, zgodnie z Twoimi preferencjami.',
                primary_btn: {
                    text: 'Przyj???? wszystko',
                    role: 'accept_all'
                },
                secondary_btn: {
                    text: 'Ustawienia',
                    role: 'settings'
                }
            },
            settings_modal: {
                title: 'Moje preferencje',
                save_settings_btn: 'Zapisa?? ustawienia',
                accept_all_btn: 'Przyj???? wszystko',
                reject_all_btn: 'Odrzu?? wszystko',
                close_btn_label: 'Zamkn????',
                blocks: [
                    {
                        title: 'Do czego s??u???? pliki cookies?',
                        description: 'Pliki cookies s?? u??ywane w celu zapewnienia podstawowych funkcji witryny i poprawy korzystania z Internetu. Dziel?? si?? na grupy. W dowolnym momencie mo??esz si?? zalogowa?? lub wylogowa?? z kt??rej?? z nich.'
                    }, {
                        title: 'Niezb??dne pliki cookies',
                        description: 'Ten rodzaj plik??w cookies jest konieczny do prawid??owego dzia??ania. Zapewniaj?? odpowiednie wy??wietlanie na monitorze i urz??dzeniach mobilnych, funkcjonalne wype??nianie i wysy??anie formularzy oraz daj?? gwarantuj?? bezpiecze??stwa. Ten typ plik??w cookies nie mo??na wy????czy??.',
                        toggle: {
                            value: 'necessary',
                            enabled: true,
                            readonly: true
                        }
                    }, {
                        title: 'Obs??uga i analiza strony internetowej',
                        description: 'Im wi??cej os??b ma w????czone statystyczne pliki cookies, tym lepiej mo??emy dostosowa?? nasz?? witryn??. Na przyk??ad poprzez przeniesienie cz??sto odwiedzanych cz????ci witryny na stron?? g????wn??, a tym samym u??atwienie wyszukiwania innym odwiedzaj??cym. Dzi??ki tym plikom jeste??my w stanie dowiedzie?? si??, sk??d ludzie do nas trafiaj??, w co klikaj?? i jak d??ugo u nas zostaj??. Przetwarzanie statystycznych plik??w cookies jest naszym prawnie uzasadnionym dzia??aniem. Pliki te przetwarzamy na podstawie Twojej zgody. W ka??dej chwili mo??esz j?? tutaj wyrazi?? lub cofn????.',
                        toggle: {
                            value: 'analytics',
                            enabled: false,
                            readonly: false
                        }
                    }, {
                        title: 'Marketing i personalizacja',
                        description: 'Dzi??ki plikom cookies stron trzecich, mo??emy przypomnie?? Ci o ofertach, kt??re przegl??da??e?? na naszej stronie i w innych miejscach w Internecie. Po wy????czeniu tych plik??w cookies, ilo???? reklam nadal b??dzie taka sama ale o rzeczach, kt??re ci?? nie interesuj??. Przetwarzamy te pliki cookies na podstawie Twojej zgody. W ka??dej chwili mo??esz j?? tutaj wyrazi?? lub cofn????.',
                        toggle: {
                            value: 'targeting',
                            enabled: false,
                            readonly: false
                        }
                    }
                ]
            }
        },
        'de': {
            consent_modal: {
                title: 'Cookies-Einstellungen: Damit die Website so bleibt, wie Sie sie kennen',
                description: 'Um auf unserer Website schnell zu finden, was Sie suchen, um viele Klicks zu sparen, ben??tigen wir Ihre Zustimmung zur Verarbeitung von Cookies, also kleinen Dateien, die in Ihrem Browser gespeichert werden. Anhand von Cookies erkennen wir Sie auf unserer Website und zeigen sie Ihnen so, dass alles funktioniert und nach Ihren Pr??ferenzen ist.',
                primary_btn: {
                    text: 'Alle akzeptieren',
                    role: 'accept_all'
                },
                secondary_btn: {
                    text: 'Einstellungen',
                    role: 'settings'
                }
            },
            settings_modal: {
                title: 'Meine Pr??ferenzen',
                save_settings_btn: 'Einstellungen speichern',
                accept_all_btn: 'Alle akzeptieren',
                reject_all_btn: 'Ablehnen',
                close_btn_label: 'Schlie??en',
                blocks: [
                    {
                        title: 'Wozu dienen Cookies?',
                        description: 'Cookies-Dateien werden verwendet, um die Grundfunktionen der Website sicherzustellen und Ihr Online-Erlebnis zu verbessern. Sie k??nnen bei jeder Kategorie jederzeit w??hlen, ob Sie sich anmelden/abmelden wollen.'
                    }, {
                        title: 'Unbedingt erforderliche Cookies',
                        description: 'Diese Cookies sind f??r den ordnungsgem????en Betrieb, die Sicherheit, die ordnungsgem????e Darstellung im Computer oder Mobiltelefon, das Ausf??llen und Versenden von Formularen usw. erforderlich. Diese Cookies k??nnen nicht deaktiviert werden, ohne sie w??rde unsere Website nicht richtig funktionieren.',
                        toggle: {
                            value: 'necessary',
                            enabled: true,
                            readonly: true
                        }
                    }, {
                        title: 'Betrieb der Website und Analyse',
                        description: 'Je mehr Personen statistische Cookies aktiviert haben, desto besser k??nnen wir unsere Website optimieren. Zum Beispiel indem wir die h??ufig besuchten Teile der Website auf die Hauptseite verschieben, und somit anderen Besuchern die Suche ersparen. Dank ihnen k??nnen wir herausfinden, woher die Besucher zu uns kommen, was sie anklicken, wie lange sie bei uns bleiben usw. Die Verarbeitung von statistischen Cookies ist unser berechtigtes Interesse. Wir verarbeiten diese Cookies auf der Grundlage Ihrer Einwilligung. Sie k??nnen diese Einwilligung jederzeit erteilen oder widerrufen.',
                        toggle: {
                            value: 'analytics',
                            enabled: false,
                            readonly: false
                        }
                    }, {
                        title: 'Marketing und Personalisierung',
                        description: 'Dank Cookies von Drittanbietern k??nnen wir Sie an die Angebote erinnern, die Sie sich auf unserer Website und anderen Stellen im Internet angesehen haben. Wenn Sie diese Cookies deaktivieren, bleiben die Anzeigen unver??ndert. Aber f??r Dinge, die Sie nicht interessieren. Wir verarbeiten diese Cookies auf der Grundlage Ihrer Einwilligung. Sie k??nnen diese Einwilligung jederzeit erteilen oder widerrufen.',
                        toggle: {
                            value: 'targeting',
                            enabled: false,
                            readonly: false
                        }
                    }
                ]
            }
        },
        'ru': {
            consent_modal: {
                title: '?????????????????? ???????????? cookie: ?????? ???????????????????? ??????-???????????????????? ??????????, ?????????? ???? ?????? ????????????',
                description: '?????????? ???????????? ?????? ???????????? ?????????? ????, ?????? ???? ?????????? ???? ?????????? ??????????, ?? ???????????????????? ?????? ?????????? ???? ?????????????? ????????????, ?????? ?????????? ???????? ???????????????? ???? ?????????????????? ???????????? cookie, ?????????????? ???????????????????????? ?????????? ?????????????????? ??????????, ???????????????????? ?? ?????????? ????????????????. ???? ???????????????????? ?????????? cookie, ?????????? ???????????????????? ?????? ???? ?????????? ?????????? ?? ???????????????????? ?????? ?????? ??????, ?????????? ?????? ?????????????????????????????? ?????????????????? ?? ?? ???????????????????????? ?? ???????????? ????????????????????????????.',
                primary_btn: {
                    text: '?????????????? ??????',
                    role: 'accept_all'
                },
                secondary_btn: {
                    text: '??????????????????',
                    role: 'settings'
                }
            },
            settings_modal: {
                title: '?????? ????????????????????????',
                save_settings_btn: '?????????????????? ??????????????????',
                accept_all_btn: '?????????????? ??????',
                reject_all_btn: '??????????????????',
                close_btn_label: '??????????????',
                blocks: [
                    {
                        title: '?????? ???????? ??????????  ?????????? cookie?',
                        description: 'Cookie ???????????????????????? ?????? ?????????????????????? ???????????????? ?????????????? ?????????? ?? ?????? ?????????????????? ???????????? ???????????????????? ?? ??????????????????. ?????? ???????????? ?????????????????? ???? ???????????? ??????????/??????????, ?????????? ??????????????????.'
                    }, {
                        title: '???????????? ?????????????????????? ?????????? cookie',
                        description: '?????? ?????????? cookie ???????????????????? ?????? ?????????????????????? ????????????????????????????????, ????????????????????????, ?????????????????????? ?????????????????????? ???? ?????????? ???????????????????? ?????? ?????????????????? ????????????????????, ???????????????????????????????? ???????????????????? ?? ???????????????? ???????? ?? ??.??. ?????????????????? ?????? ?????????? cookie ????????????????????, ?????? ?????? ?????? ???????? ???? ?????????? ?????????????????????????????? ?????????????? ??????????????.',
                        toggle: {
                            value: 'necessary',
                            enabled: true,
                            readonly: true
                        }
                    }, {
                        title: '???????????????????? ?? ???????????? ??????-??????????',
                        description: '?????? ???????????? ?????????? ?????????????? ???????????????????????????? ?????????? cookie, ?????? ?????????? ???? ???????????? ?????????????????? ?????? ????????. ????????????????, ?????????????????? ???????????????? ???????????????????? ?????????? ?????????? ?????????? ???? ?????????????? ???????????????? ?? ???????????????? ???????????? ?????????????????????? ???? ?????????????????????????? ????????????. ?????????????????? ???? ???? ?????????? ????????????, ???????????? ???????????????? ????????, ???? ?????? ?????? ??????????????, ?????? ?????????? ???????????????? ?? ??.??. ?????????????????? ???????????????????????????? ???????????? cookie ???????????????? ?????????? ???????????????? ??????????????????. ???? ???????????????????????? ?????? ?????????? cookie ???? ?????????????????? ???????????? ????????????????. ?????????? ???? ???????????? ?? ?????????? ?????????? ???????? ?????? ???????????????? ???????? ????????????????.',
                        toggle: {
                            value: 'analytics',
                            enabled: false,
                            readonly: false
                        }
                    }, {
                        title: '?????????????????? ?? ????????????????????????????',
                        description: '?????????????????? ?????????????????? ???????????? cookie ???? ?????????? ???????????????????? ?????? ?? ????????????????????????, ?????????????? ???? ?????????????????????????? ???? ?????????? ?????????? ?? ?? ???????????? ???????????? ?? ??????????????????. ???????? ???? ?????????????????? ?????? ?????????? cookie, ????????????????????  ?????????????? ?????????????????? ??????????????. ???????????? ???????? ?????? ??????????, ?????????????? ?????? ???? ????????????????????. ???? ???????????????????????? ?????? ?????????? cookie ???? ?????????????????? ???????????? ????????????????. ?????????? ???? ???????????? ?? ?????????? ?????????? ???????? ?????? ???????????????? ???????? ????????????????.',
                        toggle: {
                            value: 'targeting',
                            enabled: false,
                            readonly: false
                        }
                    }
                ]
            }
        },
        'es': {
            consent_modal: {
                title: 'Configuraci??n de las cookies: Para mantener el sitio web tal y como lo conoces',
                description: 'Para encontrar r??pidamente lo que busca en nuestro sitio, y ahorrar muchos clics, necesitamos su consentimiento para procesar las cookies, que son peque??os archivos que se almacenan en su navegador.Utilizamos las cookies para reconocerle en nuestro sitio y mostr??rselo de una forma tal que todo funcione correctamente y seg??n sus preferencias.',
                primary_btn: {
                    text: 'Aceptar todo',
                    role: 'accept_all'
                },
                secondary_btn: {
                    text: 'Ajustes',
                    role: 'settings'
                }
            },
            settings_modal: {
                title: 'Mis preferencias',
                save_settings_btn: 'Guardar ajustes',
                accept_all_btn: 'Aceptar todo',
                reject_all_btn: 'Rechazar',
                close_btn_label: 'Cerrar',
                blocks: [
                    {
                        title: '??Para qu?? sirven las cookies?',
                        description: 'Las cookies se utilizan para mantener las funciones b??sicas del sitio web y para mejorar su experiencia en l??nea. Para cada categor??a, puede elegir activarlas o desactivarlas cuando quiera.'
                    }, {
                        title: 'Cookies estrictamente necesarias',
                        description: 'Estas cookies son necesarias para el buen funcionamiento, la seguridad, la correcta visualizaci??n en su ordenador o tel??fono m??vil, el funcionamiento de los formularios en cuanto a rellenarlos y enviarlos, etc. No es posible desactivar estas cookies, sin ellas nuestro sitio no funcionar??a correctamente.',
                        toggle: {
                            value: 'necessary',
                            enabled: true,
                            readonly: true
                        }
                    }, {
                        title: 'Actividad del sitio web y an??lisis',
                        description: 'Cuantas m??s personas tengan activadas las cookies estad??sticas, m??s podremos mejorar nuestro sitio. Por ejemplo, moviendo las partes m??s visitadas del sitio a la p??gina principal y ahorrando a los dem??s visitantes tiempo para su b??squeda. Gracias a ellas, podemos saber de d??nde viene la gente, en qu?? hace clic, cu??nto tiempo se queda con nosotros, etc. El tratamiento de las cookies estad??sticas es nuestro inter??s leg??timo. Procesamos estas cookies bas??ndonos en su consentimiento. Puede dar o revocar su consentimiento aqu?? en cualquier momento.',
                        toggle: {
                            value: 'analytics',
                            enabled: false,
                            readonly: false
                        }
                    }, {
                        title: 'Marketing y personalizaci??n',
                        description: 'Gracias a las cookies de terceros, podemos recordarle las ofertas que ha visualizado en nuestro sitio web y en otros lugares de Internet. Si desactiva estas cookies, a??n habr?? la misma cantidad de anuncios. Pero ser??n sobre cosas que no le interesan. Procesamos estas cookies bas??ndonos en su consentimiento. Puede dar o revocar su consentimiento aqu?? en cualquier momento.',
                        toggle: {
                            value: 'targeting',
                            enabled: false,
                            readonly: false
                        }
                    }
                ]
            }
        }
    }
});