<?php
header("Cache-Control: max-age=84000, public");
header('Content-Type: audio/x-mpegurl');
header('Content-Disposition: attachment; filename="tvtelugutp.m3u"');
function getAllChannelInfo(): array {
    $json = @file_get_contents('https://raw.githubusercontent.com/tvtelugu/tplayself/main/tplay.json');
    if ($json === false) {
        header("HTTP/1.1 500 Internal Server Error");
        exit;
    }
    $channels = json_decode($json, true);
    if ($channels === null) {
        header("HTTP/1.1 500 Internal Server Error");
        exit;
    }
    return $channels;
}
$channels = getAllChannelInfo();
$serverAddress = $_SERVER['HTTP_HOST'] ?? 'default.server.address';
$serverPort = $_SERVER['SERVER_PORT'] ?? '80';
$serverScheme = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http';
$requestUri = $_SERVER['REQUEST_URI'] ?? '';
$dirPath = dirname($requestUri);
$portPart = ($serverPort != '80' && $serverPort != '443') ? ":$serverPort" : '';
$m3u8PlaylistFile = "#EXTM3U x-tvg-url=\"https://www.tsepg.cf/epg.xml.gz\"\n";
foreach ($channels as $channel) {
    $id = $channel['id'];
    $dashUrl = $channel['streamData']['MPD='] ?? null;
    if ($dashUrl === null) {
        continue;
    }
    $extension = pathinfo(parse_url($dashUrl, PHP_URL_PATH), PATHINFO_EXTENSION);
    $playlistUrl = "https://$serverAddress/{$id}.$extension;
    $m3u8PlaylistFile .= "#EXTINF:-1 tvg-id=\"{$id}\" tvg-logo=\"https://mediaready.videoready.tv/tatasky-epg/image/fetch/f_auto,fl_lossy,q_auto,h_250,w_250/{$channel['channel_logo']}\" group-title=\"{$channel['channel_genre'][0]}\",{$channel['channel_name']}\n";
    $m3u8PlaylistFile .= "#KODIPROP:inputstream.adaptive.license_type=clearkey\n";
    $m3u8PlaylistFile .= "#KODIPROP:inputstream.adaptive.license_key=https://fox.toxic-gang.xyz/tata/key/{$id}\n";
    $m3u8PlaylistFile .= "#EXTVLCOPT:http-user-agent=third-party\n";
    $m3u8PlaylistFile .= "$playlistUrl\n\n";
}
$additionalEntries = <<<EOT

#EXTINF:-0  tvg-id="Telugu" group-title="📻 Telugu - Radio"  tvg-logo="https://www.radio.net/images/broadcasts/0c/bf/105309/1/c300.png",Radio City Bhakti
https://stream-58.zeno.fm/2532fy6zrf9uv?zs=otQuUOufTueymnB-XuDkhw&listening-from-radio-garden=1667806138
#EXTINF:-0  tvg-id="Telugu" group-title="📻 Telugu - Radio"  tvg-logo="https://img1.wsimg.com/isteam/ip/910009e1-2553-41a8-a95d-bae75756ed2f/blob-0002.png",Melody Radio Telugu
https://n11.radiojar.com/z4qyckhr9druv?listening-from-radio-garden=1667806321&rj-tok=AAABhFEKBZkAus-NpZ-3IlDCMg&rj-ttl=5
#EXTINF:-0  tvg-id="Telugu" group-title="📻 Telugu - Radio"  tvg-logo="https://www.teluguoneradio.com/images/tori_logo.png",Telugu One Radio
https://stream.teluguoneradio.com/index.html?sid=1
#EXTINF:-0  tvg-id="Telugu" group-title="📻 Telugu - Radio"  tvg-logo="https://onlineradiofm.in/assets/image/radio/180/air-hyderabad-a.jpg",AIR Telugu - Hyderabad
https://air.pc.cdn.bitgravity.com/air/live/pbaudio032/chunklist.m3u8
EXTINF:-0 tvg-id="Telugu" group-title="📻 Telugu - Radio"  tvg-logo="https://onlineradiofm.in/assets/image/radio/180/airvisakhapc.jpg",AIR Telugu - Visakhapatnam
https://air.pc.cdn.bitgravity.com/air/live/pbaudio080/playlist.m3u8
#EXTINF:-0  tvg-id="Telugu" group-title="📻 Telugu - Radio"  tvg-logo="https://onlineradiofm.in/assets/image/radio/180/air-aadilabad.jpg",AIR Telugu - Adilabad
https://air.pc.cdn.bitgravity.com/air/live/pbaudio218/chunklist.m3u8
#EXTINF:-0  tvg-id="Telugu" group-title="📻 Telugu - Radio"  tvg-logo="https://onlineradiofm.in/assets/image/radio/180/airvijayawada.jpg",AIR Telugu - Vijayawada
https://air.pc.cdn.bitgravity.com/air/live/pbaudio175/chunklist.m3u8
#EXTINF:-0  tvg-id="Telugu" group-title="📻 Telugu - Radio"  tvg-logo="https://onlineradiofm.in/assets/image/radio/180/airtirupati.jpg",AIR Telugu - Tirupati
https://air.pc.cdn.bitgravity.com/air/live/pbaudio144/playlist.m3u8
#EXTINF:-0  tvg-id="Telugu" group-title="📻 Telugu - Radio"  tvg-logo="https://onlineradiofm.in/assets/image/radio/180/airkurnool.jpg",AIR Telugu - Kurnool
https://air.pc.cdn.bitgravity.com/air/live/pbaudio052/chunklist.m3u8
#EXTINF:-0  tvg-id="Telugu" group-title="📻 Telugu - Radio"  tvg-logo="https://onlineradiofm.in/assets/image/radio/180/aircuddapah.jpg",AIR Telugu - Cuddapah
https://air.pc.cdn.bitgravity.com/air/live/pbaudio052/chunklist.m3u8
#EXTINF:-0  tvg-id="Telugu" group-title="📻 Telugu - Radio"  tvg-logo="https://onlineradiofm.in/assets/image/radio/180/air-anantabpur.jpg",AIR Telugu - Anantapur
https://air.pc.cdn.bitgravity.com/air/live/pbaudio054/chunklist.m3u8
#EXTINF:-0  tvg-id="Telugu" group-title="📻 Telugu - Radio"  tvg-logo="https://onlineradiofm.in/assets/image/radio/180/air-nellore.jpg",AIR Telugu - Nellore
https://air.pc.cdn.bitgravity.com/air/live/pbaudio168/chunklist.m3u8
#EXTINF:-0  tvg-id="Telugu" group-title="📻 Telugu - Radio"  tvg-logo="https://onlineradiofm.in/assets/image/radio/180/airwarangal.jpg",AIR Telugu - Warangal
https://air.pc.cdn.bitgravity.com/air/live/pbaudio154/chunklist.m3u8
#EXTINF:-0  tvg-id="Telugu" group-title="📻 Telugu - Radio"  tvg-logo="https://onlineradiofm.in/assets/image/radio/180/air-nizamabad.jpg",AIR Telugu - Nizamabad
https://air.pc.cdn.bitgravity.com/air/live/pbaudio222/chunklist.m3u8
#EXTINF:-0  tvg-id="Telugu" group-title="📻 Telugu - Radio"  tvg-logo="https://onlineradiofm.in/assets/image/radio/180/airmarkapur.jpg",AIR Telugu - Markapur
https://air.pc.cdn.bitgravity.com/air/live/pbaudio039/chunklist.m3u8
#EXTINF:-0  tvg-id="Telugu" group-title="📻 Telugu - Radio"  tvg-logo="https://onlineradiofm.in/assets/image/radio/180/air-kothagudem.jpg",AIR Telugu - Kothagudem
https://air.pc.cdn.bitgravity.com/air/live/pbaudio116/chunklist.m3u8
#EXTINF:-0  tvg-id="Telugu" group-title="📻 Telugu - Radio"  tvg-logo="https://onlineradiofm.in/assets/image/radio/180/air-hyderabad-vbs.jpg",Vividh Bharati 102.8 FM in Hyderabad
https://air.pc.cdn.bitgravity.com/air/live/pbaudio034/chunklist.m3u8
#EXTINF:-0  tvg-id="Telugu" group-title="📻 Telugu - Radio"  tvg-logo="https://static.mytuner.mobi/media/tvos_radios/a8q8shxynfgk.jpg",Radio Vishnu
http://streamasiacdn.atc-labs.com/radiovishnu.aac
#EXTINF:-0  tvg-id="Telugu" group-title="📻 Telugu - Radio"  tvg-logo="https://liveradios.in/wp-content/uploads/radioguru.jpg",Radio Guru 90.4 FM
https://d33vbw5rwybpkd.cloudfront.net/vjmsradio.m3u8
#EXTINF:-0  tvg-id="Telugu" group-title="📻 Telugu - Radio"  tvg-logo="https://manaradio.in/images/mana-radio-logo.png",Mana Radio
https://securestreams7.autopo.st/?uri=http://38.68.135.17:8000/manaradio_128
#EXTINF:-0  tvg-id="Telugu" group-title="📻 Telugu - Radio"  tvg-logo="https://onlineradiofm.in/assets/image/radio/180/myindmedia.png",Myind Media Telugu
http://52.200.24.222:8000/stream
#EXTINF:-0  tvg-id="Telugu" group-title="📻 Telugu - Radio"  tvg-logo="https://onlineradiofm.in/assets/image/radio/180/Telugu%20Radio.webp",Hungama Hot Now
https://securestreams8.autopo.st:3018/1
#EXTINF:-0  tvg-id="Telugu" group-title="📻 Telugu - Radio"  tvg-logo="https://liveradios.in/wp-content/uploads/radioranjan.jpg",Radio Ranjan Cards 90.4 FM
https://ranjan.radioca.st/stream
#EXTINF:-0  tvg-id="Telugu" group-title="📻 Telugu - Radio"  tvg-logo="https://liveradios.in/wp-content/uploads/radioala.jpg",Radio Ala 90.8 FM
https://mahi.radioca.st/stream



#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",Siti Channel
https://amigofx.com:1936/sitichannel/sitichannel/playlist.m3u8

#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",Metro TV
https://gvjyg5n9doem-hls-live.qezycdn.com/metrotv/b1f4f51a218492fff9f0616b4c91297c.sdp/playlist.m3u8

#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",YSR TV Andhra Pradesh
http://telugusolutions.com:8088/ysrtv/ysrtv.m3u8

#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",Gatla TV
http://telugusolutions.com:8088/gatlatv/gatlatv.m3u8

#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",Public TV News HD
http://telugusolutions.com:8088/publictv/publictv.m3u8

#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",DBR News
http://telugusolutions.com:8088/dbr12/dbr12.m3u8

#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",MS Digital
http://telugusolutions.com:8088/msdigitaltv/msdigitaltv.m3u8

#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",RK9 News
http://telugusolutions.com:8088/rk9news/rk9news.m3u8

#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",TV7 Andhra Pradesh
https://server.streamwell.in/hls/7hills.m3u8

#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",Sree News
http://telugusolutions.com:8088/sreenews/sreenews.m3u8

#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",Blessing Tv
http://telugusolutions.com:8088/sgchannel/sgchannel.m3u8

#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",SS News
http://streamcp.logosys.cloud:1935/snewsnpt/snewsnpt/playlist.m3u8

#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",Zilla vani
https://streaming.livebox.co.in/vedhikahls/live.m3u8

#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",My3 Telugu
http://telugusolutions.com:8088/my3telugu/my3telugu.m3u8

#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",Mee TV
https://sharsolution.in/hls/meetv/meetv.m3u8

#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",S9 Channel
https://sharsolution.in/hls/s9tv/s9tv.m3u8

#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",Vinodam
https://sharsolution.in/hls/vinodam/vinodam.m3u8

#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",Cowa TV
http://live.streamplay.in:1935/cowa/cowa/playlist.m3u8

#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",Srisaila TV HD
http://202.83.27.171:1935/sslm/live/playlist.m3u8

#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",Public TV Music
http://telugusolutions.com:8088/publictvfolkmusic/publictvfolkmusic.m3u8

#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",TV 8 News
http://telugusolutions.com:8088/tv8news/tv8news.m3u8

#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",Sravya TV
http://telugusolutions.com:8088/sravyatv/sravyatv.m3u8

#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",AP Local TV
http://telugusolutions.com:8088/aplocaltv/aplocaltv.m3u8

#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",Amma News
http://server.streamplay.in:1935/ammanews/ammanews/playlist.m3u8


#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",Paraja TV
http://prajatv.mythrimediaindia.com:1935/prajatv/prajatv/index.m3u8

#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",STUDIO 18
http://cloud.streamplay.in:1935/studio18/studio18/playlist.m3u8

#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",Local News
http://live.streamplay.in:1935/localtv/localtv/playlist.m3u8

#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",Telugu TV
http://live.streamplay.in:1935/telugutv/telugutv/playlist.m3u8

#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",Sity Telagana
http://cloud.streamplay.in:1935/ccc/ccc/playlist.m3u8

#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",Greater Guntur
http://cloud.streamplay.in:1935/ggv/ggv/playlist.m3u8

#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",Bathukamma TV
http://live.streamplay.in:1935/bkamma/bkamma/playlist.m3u8

#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",News 9 Today
http://live.streamplay.in:1935/news9/news9/playlist.m3u8

#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",Samskruthi TV
http://cloud.streamplay.in:1935/telanganasamskruthi/telanganasamskruthi/playlist.m3u8

#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",99 Tv
https://ythls.armelin.one/channel/UCl5YgCiwSRVOiC2Nd1P9v1A.m3u8

#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",Vihari Tv
http://viharitv.phoenixcreations.online:1935/viharitv/viharitv/chunklist_w714070156.m3u8

#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",MA TV Telangana
http://telanganatv.phoenixcreations.online:1935/telanganatv/telanganatv/chunklist_w1691683123.m3u8

#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",BBR Tv
http://bbrtv.phoenixcreations.online:1935/bbrtv/bbrtv/chunklist_w1927464872.m3u8

#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",The Way Tv
http://198.144.149.206:8080/NOTV/THEWAYTV/index.m3u8?token=GTR

#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",New Tv Telugu
http://newtvtelugu.phoenixcreations.online:1935/newtvtelugu/newtvtelugu/chunklist_w615754673.m3u8

#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",KS Tv
https://vvsolutions.in/lmc/lmc.m3u8
    
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",Siri Channel
https://vvsolution.in/hls/sirichannel_621.m3u8
    
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",Raja Tv
https://vvsolution.in/hls/rajatv_614.m3u8
    
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",Public Tv News
https://vvsolutions.in/publictv/publictv.m3u8
    
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",Public Music
https://vvsolutions.in/publictvfolkmusic/publictvfolkmusic.m3u8
    
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",Veera Movies
https://allchannels.in/live/vvmovies_100/video.m3u8
    
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",Veera Comedy
https://allchannels.in/live/vvcomedy_100/video.m3u8
    
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",Veera HD
https://allchannels.in/vv/video.m3u8
    
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",Mtv HD
https://allchannels.in/pvphd/video.m3u8
    
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",PVP Movies
https://allchannels.in/pvpmovies/video.m3u8
    
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",Mee Tv 2
https://allchannels.in/mee/video.m3u8
    
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",DVR SITI DIGITAL
http://103.159.248.18:4444/DVR-SitiDigital-HD/index.m3u8
    
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",DVR SITI BOLLYWOOD
http://103.159.248.18:4444/DVR-Comedy-HD/index.m3u8
    
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",DVR SITI MOVIES
http://103.159.248.18:4444/DVR-Movies-HD/index.m3u8
    
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",Tv8 News 2
https://vvsolutions.in/tv8news/tv8news.m3u8
    
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",Godavari HD
https://allchannels.in/godavarihd/video.m3u8
    
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",JKC  HD
https://allchannels.in/jkc/video.m3u8
    
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",PCN HD
https://allchannels.in/pcnhd/video.m3u8
    
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",H SV News
https://allchannels.in/harikastar/video.m3u8
    
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",SITI Telugu
https://allchannels.in/sititelugu/video.m3u8
    
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",Thirumala Channel HD
https://allchannels.in/tmc/video.m3u8
    
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",GS Grameena
https://allchannels.in/gsgrameena/video.m3u8
    
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",SS News HD
https://allchannels.in/snewsnpt/video.m3u8
    
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",,GNT HD
https://allchannels.in/srkent/video.m3u8
    
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",Zoy HD
https://allchannels.in/zoyhd/video.m3u8
    
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",KCF
https://allchannels.in/kcf/video.m3u8
    
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",Sri Yadadri Tv
https://allchannels.in/sriyadadri/video.m3u8
    
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",PPS
https://allchannels.in/ppp/video.m3u8
    
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",YSR TV Telangana
https://vvsolutions.in/ysrtv/ysrtv.m3u8
    
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",SS News
http://streamcp.logosys.cloud:1935/snewsnpt/snewsnpt/playlist.m3u8

#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",Gee TV
http://live.shreyastv.in:8088/geetv/geetv.m3u8
    
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",Amma News 2
http://server.streamplay.in:1935/ammanews/ammanews/playlist.m3u8
    
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",ABN Tv
https://ythls.armelin.one/channel/UC_2irx_BQR7RsBKmUV9fePQ.m3u8
     
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",10 TV
https://ythls.armelin.one/channel/UCfymZbh17_3T_UhgjkQ9fRQ.m3u8
    
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",Mahaa News
https://ythls.armelin.one/channel/UCDKjhgRoPF1CQk7HluMz23A.m3u8
    
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",Sathya Tv
https://amigofx.com:1936/sattvatv/sattvatv/playlist.m3u8
    
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",SRS Bakthi TV
http://live.adostream.com:1935/srsbhakthi/srsbhakthi/playlist.m3u8
    
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",YUPP TV VEDA
https://jiotv-portal.dinesh29.com.np/live/jiotv-portal-universal/yupp-tv-veda-4k/index.ts
    
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",Gospel Tv
http://live.adostream.com:1935/gospeltv/gospeltv/playlist.m3u8
    
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",Bakthi TV
https://segment.yuppcdn.net/240122/bhakti/240122/bhakti_1800/chunks.m3u8
    
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",EMFGC Tv
http://198.144.149.206:8080/NOTV/EMGC/tracks-v1a1/mono.m3u8?token=GTR
    
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",SVBC1
https://player.mslivestream.net/telugu/5d076e5c3d34cb8bb08e54a4bb7e223e.sdp/playlist.m3u8
    
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",SVBC2
http://player.mslivestream.net/tamil/ac206e74d75b285755ee4924df87d951.sdp/index.m3u8
    
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",SVBC3
https://player.mslivestream.net/svbc/2e628d7e1b65d31254fd7705ff7ee64d.sdp/playlist.m3u8
    
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",SVBC4
https://player.mslivestream.net/mslive/13a2927187b9700ae7ea82d7841d5b68.sdp/playlist.m3u8
    
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",Studio N
http://studion.phoenixcreations.online:1935/studion/studion/chunklist_w1111213889.m3u8
    
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",Mana Telugu Tv News
http://decode.streamplay.in:1935/telugutv/telugutv/chunklist_w2044669398.m3u8
    
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",Super TV
http://server.streamplay.in:1935/supertv/supertv/playlist.m3u8

#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",V6 News Tv
https://medtaor.akamaized.net/v1/master/a0d007312bfd99c47f76b77ae26b1ccdaae76cb1/plives/140622/v6news/playlist.m3u8
    
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",Tv5 News tv
https://medtaor.akamaized.net/v1/master/a0d007312bfd99c47f76b77ae26b1ccdaae76cb1/plives/110322/tv5/playlist.m3u8
    
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",Sagar Express Tv
http://sexpress.mythrimediaindia.com:1935/sexpress/sexpress/index.m3u8
    
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",Shakthi Tv
http://shakthitv.mythrimediaindia.com:1935/shakthitv/shakthitv/tracks-v1a1/mono.m3u8
    
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",Sri Chakra Tv
http://srichakra.mythrimediaindia.com:1935/srichakra/srichakra/chunklist_w922956034.m3u8
    
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",Channel 9 News
http://channel9hd.in:1935/hd/hd/chunklist_w1051485029.m3u8
    
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",Satya News Tv
http://103.146.170.102:1935/satya/satya/chunklist_w1792896619.m3u8
    
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",BV9 News
http://rikuta.in:1935/bv9/bv9/chunklist_w1435248932.m3u8
    
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",G Plus
http://gchannel.mythrimediaindia.com:1935/gchannel/gchannel/tracks-v1a1/mono.m3u8
    
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",Tv9 news
https://dyjmyiv3bp2ez.cloudfront.net/pub-iotv9telcmjhcs/liveabr/playlist.m3u8
    
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",Veera Songs
https://allchannels.in/veerasongs/veerasongs/video.m3u8
    
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",DVR SITI  MUSIC
http://103.159.248.18:4444/DVR-Music-HD/index.m3u8
    
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 Telugu - Local Tv",AVN TV
http://avntv.logosys.in:8080/hls/avntv.m3u8

#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 DTH - Telugu",Gemini TV
http://116.202.46.40:9023/GEMINI_TELUGU/index.m3u8

#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 DTH - Telugu",Gemini Movies HD
http://116.202.46.40:9023/GEMINI_MOVIES_TELUGU/index.m3u8

#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 DTH - Telugu",Gemini Comedy
http://116.202.46.40:9023/GEMINI_COMEDY_TELUGU/index.m3u8

#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 DTH - Telugu",Gemini Life
http://116.202.46.40:9023/GEMINI_LIFE_TELUGU/index.m3u8

#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 DTH - Telugu",Zee Telugu
http://116.202.46.40:9023/ZEE_TELUGU/index.m3u8

#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 DTH - Telugu",Zee Cinemalu HD
http://116.202.46.40:9023/ZEE_CINEMALU_TELUGU/index.m3u8

#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 DTH - Telugu",Star Maa
http://116.202.46.40:9023/STAR_MAA_TELUGU/index.m3u8

#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 DTH - Telugu",Star Maa Movies
http://116.202.46.40:9023/STAR_MAA_MOVIES_TELUGU/index.m3u8

#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 DTH - Telugu",ETV Telugu
http://116.202.46.40:9023/ETV_TELUGU/index.m3u8

#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 DTH - Telugu",ETV Plus HD
http://116.202.46.40:9023/ETV_PLUS_TELUGU/index.m3u8

#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 DTH - Telugu",ETV Cinema
http://116.202.46.40:9023/ETV_CINEMA_TELUGU/index.m3u8

#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 DTH - Telugu",ETV Life
http://116.202.46.40:9023/ETV_LIFE_TELUGU/index.m3u8

#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 DTH - Telugu",Star Maa Music
http://116.202.46.40:9023/STAR_MAA_MUSIC_TELUGU/index.m3u8

#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/play/main/images/TVTELUGU-B.png" group-title="🎭 DTH - Telugu",Gemini Music
http://116.202.46.40:9023/GEMINI_MUSIC_TELUGU/index.m3u8


#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🍿 24/7 Movies - Telugu",Telugu MOVIES (2021-22)
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/121374.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🍿 24/7 Movies - Telugu",TELUGU-MOVIES 1 HD
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/136457.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🍿 24/7 Movies - Telugu",TELUGU-MOVIES 2 HD
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/136458.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🍿 24/7 Movies - Telugu",TELUGU-MOVIES 3 HD
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/136459.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🍿 24/7 Movies - Telugu",TELUGU-MOVIES 4 HD
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/136460.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🍿 24/7 Movies - Telugu",TELUGU-EROSNOW MOVIES 1 HD
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/136461.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🍿 24/7 Movies - Telugu",TELUGU-CLASSIC MOVIES 1 HD
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/136462.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🍿 24/7 Movies - Telugu",TELUGU-CLASSIC MOVIES 2 HD
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/136463.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🍿 24/7 Movies - Telugu",TELUGU-LATTEST MOVIES 1 HD
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/136464.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🍿 24/7 Movies - Telugu",TELUGU-LATTEST MOVIES 2 HD
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/136465.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🍿 24/7 Movies - Telugu",TELUGU-ACTION DRAMA MOVIES HD
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/136466.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🍿 24/7 Movies - Telugu",TELUGU-COMEDY MOVIES HD
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/136467.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🍿 24/7 Movies - Telugu",TELUGU-ACTION CRIME MOVIES HD
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/136468.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🍿 24/7 Movies - Telugu",TELUGU-ACTION THRILLER MOVIES HD
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/136469.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🍿 24/7 Movies - Telugu",TELUGU-THRILLER MOVIES HD
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/136470.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🍿 24/7 Movies - Telugu",TELUGU-ROMANCE MOVIES HD
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/136471.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🍿 24/7 Movies - Telugu",TELUGU-MYSTERY MOVIES HD
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/136472.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🍿 24/7 Movies - Telugu",TELUGU-COMEDY ROMANCE MOVES HD
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/136473.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🍿 24/7 Movies - Telugu",TELUGU-COMEDY DRAMA MOVIES HD
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/136474.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🍿 24/7 Movies - Telugu",TELUGU-CRIME MOVIES HD
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/136475.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🍿 24/7 Movies - Telugu",TELUGU-CRIME DRAMA MOVIES HD
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/136476.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🍿 24/7 Movies - Telugu",TELUGU-DRAMA MOVIES HD
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/136477.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🍿 24/7 Movies - Telugu",TELUGU-DRAMA ROMANCE MOVIES HD
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/136478.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🍿 24/7 Movies - Telugu",TELUGU-DRAMA THRILLER MOVIES HD
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/136479.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🍿 24/7 Movies - Telugu",TELUGU-FANTASY MOVIES HD
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/136480.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🍿 24/7 Movies - Telugu",TELUGU-HORROR MOVIES HD
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/136481.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🍿 24/7 Movies - Telugu",TELUGU-HORROR THRILLER MOVIES HD
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/136482.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🍿 24/7 Movies - Telugu",TELUGU-MUSICAL MOVIES HD
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/136483.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",BooBa
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/121314.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Rick And Morty
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/121329.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Masha and the Bear
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/121337.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Little Baby Bum
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/121339.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",The Boss Baby_ Back in Business
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/121340.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Peppa Pig
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/121343.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Blippi
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/121368.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Gabby_s Dollhouse
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/121376.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Bear in the Big Blue House
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224678.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Bigger
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224679.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Biker Mice from Mars
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224680.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Butterbeans Café
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224681.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Chip and Dale Rescue Rangers
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224682.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Danger Mouse (1981)
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224683.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Dennis the Menace
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224684.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Dinosaurs
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224685.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Disney Movies
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224686.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Disneys Adventures of the Gummi Bears
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224687.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Dragon Ball Super
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224688.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Dragons-Race to the Edge
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224689.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Duck Dodgers
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224690.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",DuckTales
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224691.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Garfield and Friends
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224692.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Grizzy-the Lemmings
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224693.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Handy Manny
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224694.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Harvey Birdman-Attorney at Law
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224695.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Hey Arnold!
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224696.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",iCarly
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224697.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Inspector Gadget
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224698.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Inspector Gadget
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224699.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Jake and the Never Land Pirates
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224700.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Johnny Test
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224701.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Loo Loo Kids Johny & Friends Musical Adventure
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224702.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Looney Tunes
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224703.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Mickey and the Roadster Racers
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224704.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Mickey Mouse Clubhouse
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224705.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Motown Magic
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224706.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Muppet Babies
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224707.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Octonauts
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224708.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Paradise PD
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224709.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",PAW Patrol
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224710.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Pinky and the Brain
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224711.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",PJ Masks
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224712.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Reading Rainbow
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224713.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Rugrats
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224714.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Scooby-Doo! Mystery Incorporated
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224715.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Scooby-Doo, Where Are You?
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224716.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Special Agent Oso
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224717.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Spider-Man: The New Animated Series
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224718.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Super Friends
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224719.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",SWAT Kats: The Radical Squadron
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224720.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",T.O.T.S.
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224721.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",TaleSpin
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224722.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",The Adventures of Rocky and Bullwinkle
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224723.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",The Adventures of Super Mario Bros. 3
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224724.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",The Fairly OddParents
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224725.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",The Incredibles
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224726.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",The Jetsons
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224727.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",The Little Mermaid
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224728.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",The Loud House
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224729.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",The Super Mario Bros. Super Show!
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224730.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",The Sylvester & Tweety Mysteries
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224731.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Trolls: The Beat Goes On!
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224732.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Trolls: TrollsTopia
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224733.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Ultimate Spider-Man
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224734.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Vampirina
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224735.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Wacky Races
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224736.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Asterix
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224737.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Batman Brave And The Bold
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224738.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Batman The Animated Series
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224739.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Ben 10
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224740.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Ben And Holly
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224741.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Despicable Me
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224742.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Disney Movies 2
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224743.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Disney Movies 3
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224744.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Doc Mcstuffins
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224745.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Doc Mcstuffins
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224746.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Doc Mcstuffins
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224747.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Dora The Explorer
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224748.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Dr Seuss
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224749.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Dragonball Z
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224750.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Drake And Josh
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224751.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Dreamworks Animation
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224752.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Fairly Odd Parents
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224753.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Fancy Nancy
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224754.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Fireman Sam
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224755.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Gravity Falls
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224756.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",In The Night Garden
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224757.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Johnny Bravo
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224758.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Lego Movies
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224759.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Lego Star Wars
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224760.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Milly And Molly
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224761.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Mr Bean Animated
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224762.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Peppa Pig
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224763.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Pokemon
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224764.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Powerpuff Girls
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224765.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Scooby Doo
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224766.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Shaun The Sheep
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224767.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Sofia The First
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224768.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Spongebob Squarepants
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224769.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Steven Universe
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224770.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Teen Titans Go
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224771.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",The Batman
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224772.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",The Regular Show
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224773.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",The Spectacular Spiderman
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224774.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Tom And Jerry
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224775.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Top Cat
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224776.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",X-Men Cartoon
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224777.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",VEGGIETALES
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224778.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Clifford the Big Red Dog
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224779.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Halloween Movies
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224780.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Doctor Who
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224781.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",CHiPs
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224782.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Jessie
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224783.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Phineas and Ferb
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224784.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Star Trek: Voyager
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224785.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Star Trek: Enterprise
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224786.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Disney Gallery-Star Wars The Mandalorian
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224787.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Star Trek: Lower Decks
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224788.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Star Trek: Prodigy
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224789.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Star vs. the Forces of Evil
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224790.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Star Wars Rebels
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224791.ts
#EXTINF:-1 tvg-logo="https://raw.githubusercontent.com/tvtelugu/tvteluguplay/main/images/TVTELUGU-B.png" group-title="🧸 24/7 Kids",Star Wars: The Clone Wars
http://starshare.live:8080/live/rvdgdf7647564/bvchgfd235454/224792.ts




#EXTINF:-1 tvg-logo="https://mediaready.videoready.tv/tatasky-epg/image/fetch/f_auto,fl_lossy,q_auto,h_250,w_250/https://ltsk-cdn.s3.eu-west-1.amazonaws.com/jumpstart/Temp_Live/cdn/HLS/Channel/imageContent-11073-j95e7nyo-v1/imageContent-11073-j95e7nyo-m1.png" group-title="📱 ZEE5",Zee TV HD
#EXTVLCOPT:http-user-agent=Mozilla/5.0
https://la.drmlive.au/tp/zee.php?id=tvhd
#EXTINF:-1 tvg-logo="https://mediaready.videoready.tv/tatasky-epg/image/fetch/f_auto,fl_lossy,q_auto,h_250,w_250/https://ltsk-cdn.s3.eu-west-1.amazonaws.com/jumpstart/Temp_Live/cdn/HLS/Channel/imageContent-117-j5fl7440-v1/imageContent-117-j5fl7440-m1.png" group-title="📱 ZEE5",&tv HD
#EXTVLCOPT:http-user-agent=Mozilla/5.0
https://la.drmlive.au/tp/zee.php?id=andtvhd
#EXTINF:-1 tvg-logo="https://mediaready.videoready.tv/tatasky-epg/image/fetch/f_auto,fl_lossy,q_auto,h_250,w_250/https://ltsk-cdn.s3.eu-west-1.amazonaws.com/jumpstart/Temp_Live/cdn/HLS/Channel/XPOHD_Thumbnail-v1/XPOHD_Thumbnail.png" group-title="📱 ZEE5",&Xplor HD
#EXTVLCOPT:http-user-agent=Mozilla/5.0
https://la.drmlive.au/tp/zee.php?id=andxplorehd
#EXTINF:-1 tvg-logo="https://mediaready.videoready.tv/tatasky-epg/image/fetch/f_auto,fl_lossy,q_auto,h_250,w_250/https://ltsk-cdn.s3.eu-west-1.amazonaws.com/jumpstart/Temp_Live/cdn/HLS/Channel/imageContent-11173-j9hth720-v1/imageContent-11173-j9hth720-m1.png" group-title="📱 ZEE5",&pictures HD
#EXTVLCOPT:http-user-agent=Mozilla/5.0
https://la.drmlive.au/tp/zee.php?id=andpictureshd
#EXTINF:-1 tvg-logo="https://mediaready.videoready.tv/tatasky-epg/image/fetch/f_auto,fl_lossy,q_auto,h_250,w_250/https://ltsk-cdn.s3.eu-west-1.amazonaws.com/jumpstart/Temp_Live/cdn/HLS/Channel/imageContent-11915-j9l5clzs-v1/imageContent-11915-j9l5clzs-m1.png" group-title="📱 ZEE5",Zee Cinema HD
#EXTVLCOPT:http-user-agent=Mozilla/5.0
https://la.drmlive.au/tp/zee.php?id=cinemahd
#EXTINF:-1 tvg-logo="https://upload.wikimedia.org/wikipedia/commons/1/12/%26flix_logo.png" group-title="🌟 Jio Cinema",&flix HD
#EXTVLCOPT:http-user-agent=Mozilla/5.0
https://la.drmlive.au/tp/zee.php?id=andflixhd
#EXTINF:-1 tvg-logo="https://upload.wikimedia.org/wikipedia/en/0/0b/Zee_Zest_logo.jpeg" group-title="📱 ZEE5",Zee Zest HD
#EXTVLCOPT:http-user-agent=Mozilla/5.0
https://la.drmlive.au/tp/zee.php?id=zesthd
#EXTINF:-1 tvg-logo="https://mediaready.videoready.tv/tatasky-epg/image/fetch/f_auto,fl_lossy,q_auto,h_250,w_250/https://ltsk-cdn.s3.eu-west-1.amazonaws.com/jumpstart/Temp_Live/cdn/HLS/Channel/imageContent-11266-j9j2spmg-v1/imageContent-11266-j9j2spmg-m1.png" group-title="📱 ZEE5",Big Magic
#EXTVLCOPT:http-user-agent=Mozilla/5.0
https://la.drmlive.au/tp/zee.php?id=bigmagic
#EXTINF:-1 tvg-logo="https://upload.wikimedia.org/wikipedia/commons/thumb/7/77/%26priv%C3%A9_HD.svg/2880px-%26priv%C3%A9_HD.svg.png" group-title="📱 ZEE5",&prive HD
#EXTVLCOPT:http-user-agent=Mozilla/5.0
https://la.drmlive.au/tp/zee.php?id=privehd
#EXTINF:-1 tvg-logo="https://upload.wikimedia.org/wikipedia/en/a/a4/Zee_Action_2023_logo.png" group-title="📱 ZEE5",Zee Action
#EXTVLCOPT:http-user-agent=Mozilla/5.0
https://la.drmlive.au/tp/zee.php?id=action
#EXTINF:-1 tvg-logo="https://mediaready.videoready.tv/tatasky-epg/image/fetch/f_auto,fl_lossy,q_auto,h_250,w_250/https://ltsk-cdn.s3.eu-west-1.amazonaws.com/jumpstart/Temp_Live/cdn/HLS/Channel/imageContent-31233-jli1wlvc-v1/imageContent-31233-jli1wlvc-m1.png" group-title="📱 ZEE5",Zee Bollywood
#EXTVLCOPT:http-user-agent=Mozilla/5.0
https://la.drmlive.au/tp/zee.php?id=bollywood
#EXTINF:-1 tvg-logo="https://mediaready.videoready.tv/tatasky-epg/image/fetch/f_auto,fl_lossy,q_auto,h_250,w_250/https://ltsk-cdn.s3.eu-west-1.amazonaws.com/jumpstart/Temp_Live/cdn/HLS/Channel/imageContent-11090-j95hdh6o-v1/imageContent-11090-j95hdh6o-m1.png" group-title="📱 ZEE5",Zee Anmol Cinema
#EXTVLCOPT:http-user-agent=Mozilla/5.0
https://la.drmlive.au/tp/zee.php?id=anmolcinema
#EXTINF:-1 tvg-logo="https://upload.wikimedia.org/wikipedia/en/1/14/Zee_Caf%C3%A9_2011_logo.png" group-title="📱 ZEE5",Zee Cafe HD
#EXTVLCOPT:http-user-agent=Mozilla/5.0
https://la.drmlive.au/tp/zee.php?id=cafehd
#EXTINF:-1 tvg-logo="https://mediaready.videoready.tv/tatasky-epg/image/fetch/f_auto,fl_lossy,q_auto,h_250,w_250/https://ltsk-cdn.s3.eu-west-1.amazonaws.com/jumpstart/Temp_Live/cdn/HLS/Channel/imageContent-11969-j9luigc0-v2/imageContent-11969-j9luigc0-m2.png" group-title="📱 ZEE5",Zee Anmol
#EXTVLCOPT:http-user-agent=Mozilla/5.0
https://la.drmlive.au/tp/zee.php?id=anmol
#EXTINF:-1 tvg-logo="https://mediaready.videoready.tv/tatasky-epg/image/fetch/f_auto,fl_lossy,q_auto,h_250,w_250/https://ltsk-cdn.s3.eu-west-1.amazonaws.com/jumpstart/Temp_Live/cdn/HLS/Channel/imageContent-49009-k5g6nid4-v1/imageContent-49009-k5g6nid4-m1.png" group-title="📱 ZEE5",Zee Punjabi
#EXTVLCOPT:http-user-agent=Mozilla/5.0
https://la.drmlive.au/tp/zee.php?id=punjabi

#EXTINF:-1 tvg-logo="http://jiotv.catchup.cdn.jio.com/dare_images/images/Sony_HD.png" group-title="🌟 SonyLiv",SONY HD
https://la.drmlive.au/tp/sliv.php?id=sony
#EXTINF:-1 tvg-logo="http://jiotv.catchup.cdn.jio.com/dare_images/images/Sony_SAB_HD.png" group-title="🌟 SonyLiv",SONY SAB HD
https://la.drmlive.au/tp/sliv.php?id=sab
#EXTINF:-1 tvg-logo="https://i.postimg.cc/ZqnmcXdx/Sony-KAL.png" group-title="🌟 SonyLiv",SONY KAL
https://spt-sonykal-1-us.lg.wurl.tv/playlist.m3u8
#EXTINF:-1 tvg-logo="http://jiotv.catchup.cdn.jio.com/dare_images/images/Sony_Pal.png" group-title="🌟 SonyLiv",SONY PAL
https://la.drmlive.au/tp/sliv.php?id=pal
#EXTINF:-1 tvg-logo="http://jiotv.catchup.cdn.jio.com/dare_images/images/Sony_Wah.png" group-title="🌟 SonyLiv",SONY WAH
https://la.drmlive.au/tp/sliv.php?id=wah
#EXTINF:-1 tvg-logo="http://jiotv.catchup.cdn.jio.com/dare_images/images/SET_MAX.png" group-title="🌟 SonyLiv",SONY MAX
https://la.drmlive.au/tp/sliv.php?id=max
#EXTINF:-1 tvg-logo="http://jiotv.catchup.cdn.jio.com/dare_images/images/Sony_Max_HD.png" group-title="🌟 SonyLiv",SONY MAX HD
https://la.drmlive.au/tp/sliv.php?id=maxhd
#EXTINF:-1 tvg-logo="http://jiotv.catchup.cdn.jio.com/dare_images/images/Sony_MAX2.png" group-title="🌟 SonyLiv",SONY MAX2
https://la.drmlive.au/tp/sliv.php?id=max2
#EXTINF:-1 tvg-logo="http://jiotv.catchup.cdn.jio.com/dare_images/images/Ten_HD.png" group-title="🌟 SonyLiv",SONY TEN 1 HD
https://la.drmlive.au/tp/sliv.php?id=ten1hd
#EXTINF:-1 tvg-logo="http://jiotv.catchup.cdn.jio.com/dare_images/images/Ten_1.png" group-title="🌟 SonyLiv",SONY TEN 1
https://la.drmlive.au/tp/sliv.php?id=ten1
#EXTINF:-1 tvg-logo="http://jiotv.catchup.cdn.jio.com/dare_images/images/Ten2_HD.png" group-title="🌟 SonyLiv",SONY TEN 2 HD
https://la.drmlive.au/tp/sliv.php?id=ten2hd
#EXTINF:-1 tvg-logo="https://jiotv.catchup.cdn.jio.com/dare_images/images/Ten_2.png" group-title="🌟 SonyLiv",SONY TEN 2
https://la.drmlive.au/tp/sliv.php?id=ten2
#EXTINF:-1 tvg-logo="http://jiotv.catchup.cdn.jio.com/dare_images/images/Ten3_HD.png" group-title="🌟 SonyLiv",SONY TEN 3 HD
https://la.drmlive.au/tp/sliv.php?id=ten3hd
#EXTINF:-1 tvg-logo="http://jiotv.catchup.cdn.jio.com/dare_images/images/Ten_3.png" group-title="🌟 SonyLiv",SONY TEN 3
https://la.drmlive.au/tp/sliv.php?id=ten3
#EXTINF:-1 tvg-logo="https://www.sonypicturesnetworks.com/images/logos/SONY_SportsTen4_HD_Logo_CLR.png" group-title="🌟 SonyLiv",SONY TEN 4 HD
https://la.drmlive.au/tp/sliv.php?id=ten4hd
#EXTINF:-1 tvg-logo="https://www.sonypicturesnetworks.com/images/logos/SONY_SportsTen4_SD_Logo_CLR.png" group-title="🌟 SonyLiv",SONY TEN 4 
https://la.drmlive.au/tp/sliv.php?id=ten4
#EXTINF:-1 tvg-logo="https://www.sonypicturesnetworks.com/images/logos/SONY_SportsTen5_HD_Logo_CLR.png" group-title="🌟 SonyLiv",SONY TEN 5 HD
https://la.drmlive.au/tp/sliv.php?id=ten5hd
#EXTINF:-1 tvg-logo="https://www.sonypicturesnetworks.com/images/logos/SONY_SportsTen5_SD_Logo_CLR.png" group-title="🌟 SonyLiv",SONY TEN 5 
https://la.drmlive.au/tp/sliv.php?id=ten5
#EXTINF:-1 tvg-logo="http://jiotv.catchup.cdn.jio.com/dare_images/images/Sony_BBC_Earth_HD.png" group-title="🌟 SonyLiv",SONY BBC EARTH
https://la.drmlive.au/tp/sliv.php?id=bbc
#EXTINF:-1 tvg-logo="http://jiotv.catchup.cdn.jio.com/dare_images/images/Sony_Yay_Hindi.png" group-title="🌟 SonyLiv",SONY YAY
https://la.drmlive.au/tp/sliv.php?id=yay
#EXTINF:-1 tvg-logo="http://jiotv.catchup.cdn.jio.com/dare_images/images/Sony_Pix_HD.png" group-title="🌟 SonyLiv",SONY PIX HD
https://la.drmlive.au/tp/sliv.php?id=pix
#EXTINF:-1 tvg-logo="http://jiotv.catchup.cdn.jio.com/dare_images/images/Sony_Marathi_SD.png" group-title="🌟 SonyLiv",SONY MARATHI
https://la.drmlive.au/tp/sliv.php?id=marathi
#EXTINF:-1 tvg-logo="http://jiotv.catchup.cdn.jio.com/dare_images/images/Sony_aath.png" group-title="🌟 SonyLiv",SONY AATH 
https://la.drmlive.au/tp/sliv.php?id=aath

#EXTINF:-1 tvg-id="144" group-title="🌟 Jio Cinema" tvg-language="Hindi" tvg-logo="https://v3img.voot.com/resizeMedium,w_1090,h_613/v3Storage/assets/colors-hindi--16x9-1714557869344.jpg",Colors HD
https://prod-sports-hin-fa.jiocinema.com/bpk-tv/JC_ColorsHD/JCHLS/index.m3u8
#EXTINF:-1 tvg-id="1370" group-title="🌟 Jio Cinema" tvg-language="Hindi" tvg-logo="https://v3img.voot.com/resizeMedium,w_450,h_253/v3Storage/assets/collors-rishtey-live-channels-16x9-3-1642676080416-1674198105431-1697532377978.jpg",Rishtey
https://prod-sports-hin-fa.jiocinema.com/bpk-tv/JC_ColorsRishtey/JCHLS/index.m3u8
#EXTINF:-1 tvg-id="756" group-title="🌟 Jio Cinema" tvg-language="Bengali" tvg-logo="https://v3img.voot.com/resizeMedium,w_450,h_253/v3Storage/assets/colors-bangla-new-16x9-4-1649659533344.jpg",Colors Bengla HD
https://prod-sports-hin-fa.jiocinema.com/bpk-tv/JC_ColorsBanglaHD/JCHLS/index.m3u8
#EXTINF:-1 tvg-id="757" group-title="🌟 Jio Cinema" tvg-language="Kannada" tvg-logo="https://v3img.voot.com/resizeMedium,w_450,h_253/v3Storage/assets/colors-kannada-16x9-1677754085834.jpg",Colors Kannada HD
https://prod-sports-hin-fa.jiocinema.com/bpk-tv/JC_ColorsKannadaHD/JCHLS/index.m3u8
#EXTINF:-1 tvg-id="755" group-title="🌟 Jio Cinema" tvg-language="Marathi" tvg-logo="https://v3img.voot.com/resizeMedium,w_450,h_253/v3Storage/assets/colors-marathi-live-channels-16x9-4-6-apr-1649257093359.jpg",Colors Marathi HD
https://prod-sports-hin-fa.jiocinema.com/bpk-tv/JC_ColorsMarathiHD/JCHLS/index.m3u8
#EXTINF:-1 tvg-id="196" group-title="🌟 Jio Cinema" tvg-language="Gujarati" tvg-logo="https://v3img.voot.com/resizeMedium,w_450,h_253/v3Storage/assets/colors-gujarati-16x9-1713269620328.jpg",Colors Gujarati
https://prod-sports-hin-fa.jiocinema.com/bpk-tv/JC_ColorsGujarati/JCHLS/index.m3u8
#EXTINF:-1 tvg-id="429" group-title="🌟 Jio Cinema" tvg-language="Tamil" tvg-logo="https://v3img.voot.com/resizeMedium,w_450,h_253/v3Storage/assets/ct-1644165913136.jpg",Colors Tamil HD
https://prod-sports-hin-fa.jiocinema.com/bpk-tv/JC_ColorsTamilHD/JCHLS/index.m3u8
#EXTINF:-1 tvg-id="198" group-title="🌟 Jio Cinema" tvg-language="Odia" tvg-logo="https://v3img.voot.com/resizeMedium,w_450,h_253/v3Storage/assets/colors-odia-live-channels-16x9-4-1642583679866.jpg",Colors Oriya
https://prod-sports-hin-fa.jiocinema.com/bpk-tv/JC_ColorsOriya/JCHLS/index.m3u8
#EXTINF:-1 tvg-id="1158" group-title="🌟 Jio Cinema" tvg-language="English" tvg-logo="https://v3img.voot.com/resizeMedium,w_450,h_253/v3Storage/assets/colors-infinity-live-channels-16x9-1642496946057.jpg",Colors Infinity HD
https://prod-sports-hin-fa.jiocinema.com/bpk-tv/JC_ColorsInfinityHD/JCHLS/index.m3u8
#EXTINF:-1 tvg-id="785" group-title="🌟 Jio Cinema" tvg-language="Kannada" tvg-logo="https://v3img.voot.com/resizeMedium,w_450,h_253/v3Storage/assets/colors-super-live-channels-16x9-4-1642744939924.jpg",Colors Super
https://prod-sports-hin-fa.jiocinema.com/bpk-tv/JC_ColorsSuperKannada/JCHLS/index.m3u8
#EXTINF:-1 tvg-id="1477" group-title="🌟 Jio Cinema" tvg-language="Hindi" tvg-logo="https://v3img.voot.com/resizeMedium,w_450,h_253/v3Storage/assets/Live-Tv-Channels-colors-cineplex-1607514413063.jpg",Colors Cineplex HD
https://prod-sports-hin-fa.jiocinema.com/bpk-tv/JC_ColorsCineplexHD/JCHLS/index.m3u8
#EXTINF:-1 tvg-id="1450" group-title="🌟 Jio Cinema" tvg-language="Hindi" tvg-logo="https://v3img.voot.com/resizeMedium,w_960,h_540/v3Storage/assets/colors-cineplex-superhit%2016x9-1648793655358.jpg",Colors Cineplex Superhit
https://prod-sports-hin-fa.jiocinema.com/bpk-tv/JC_RishteyCineplex/JCHLS/index.m3u8
#EXTINF:-1 tvg-id="1763" group-title="🌟 Jio Cinema" tvg-language="Hindi" tvg-logo="https://v3img.voot.com/resizeMedium,w_450,h_253/v3Storage/assets/cineplex-1713963820848.jpeg",Colors Cineplex Bollywood
https://prod-sports-hin-fa.jiocinema.com/bpk-tv/JC_ColorsCineplexBollywood/JCHLS/index.m3u8
#EXTINF:-1 tvg-id="1632" group-title="🌟 Jio Cinema" tvg-language="Kannada" tvg-logo="https://v3img.voot.com/resizeMedium,w_450,h_253/v3Storage/assets/colors-kannada-cinema-16x9-1713963481807.jpg",Colors Kannada Cinema
https://prod-sports-hin-fa.jiocinema.com/bpk-tv/JC_ColorsKannadaCinema/JCHLS/index.m3u8
#EXTINF:-1 tvg-id="1145" group-title="🌟 Jio Cinema" tvg-language="Hindi" tvg-logo="https://v3img.voot.com/resizeMedium,w_450,h_253/v3Storage/assets/mtv-16x9-1714316345624.jpg",MTV HD
https://prod-sports-hin-fa.jiocinema.com/bpk-tv/JC_MTVHD/JCHLS/index.m3u8
#EXTINF:-1 tvg-id="753" group-title="🌟 Jio Cinema" tvg-language="Hindi" tvg-logo="https://v3img.voot.com/resizeMedium,w_450,h_253/v3Storage/assets/mtv-beats-live-channels-16x9-1642675874665.jpg",MTV Beats HD
https://prod-sports-hin-fa.jiocinema.com/bpk-tv/JC_MTVBeatsHD/JCHLS/index.m3u8
#EXTINF:-1 tvg-id="544" group-title="🌟 Jio Cinema" tvg-language="Hindi" tvg-logo="https://v3img.voot.com/resizeMedium,w_450,h_253/v3Storage/assets/nick-jr-16x9-2-1626708077243.jpg",Nick Junior
https://prod-sports-hin-fa.jiocinema.com/bpk-tv/JC_NickJr/JCHLS/index.m3u8
#EXTINF:-1 tvg-id="1226" group-title="🌟 Jio Cinema" tvg-language="English" tvg-logo="https://v3img.voot.com/resizeMedium,w_1090,h_613/v3Storage/assets/nick-hd-plus-live-channels-16x9-4-1642585145139.jpg",Nick HD+
https://prod-sports-hin-fa.jiocinema.com/bpk-tv/JC_NickHD/JCHLS/index.m3u8
#EXTINF:-1 tvg-id="815" group-title="🌟 Jio Cinema" tvg-language="Hindi" tvg-logo="https://v3img.voot.com/resizeMedium,w_450,h_253/v3Storage/assets/sonic-16x9-2-1626707025539.jpg",Sonic
https://prod-sports-hin-fa.jiocinema.com/bpk-tv/JC_SonicNick/JCHLS/index.m3u8
#EXTINF:-1 tvg-id="1226" group-title="🌟 Jio Cinema" tvg-language="English" tvg-logo="https://v3img.voot.com/resizeMedium,w_450,h_253/v3Storage/assets/sports18_tray-1693930594270.jpg",SPORTS 18 HD
https://prod-sports-hin-fa.jiocinema.com/bpk-tv/JC_Sports18_1HD/JCHLS/index.m3u8
#EXTINF:-1 tvg-id="1998" group-title="🌟 Jio Cinema" tvg-language="Hindi" tvg-logo="https://v3img.voot.com/resizeMedium,w_1090,h_613/v3Storage/assets/sports18_khel_tray-1693931658589.jpg",SPORTS 18 Khel
https://prod-sports-hin-fa.jiocinema.com/bpk-tv/Sports18_Khel_voot_MOB/Fallback/index.m3u8
#EXTINF:-1 tvg-id="2000" group-title="🌟 Jio Cinema" tvg-language="Hindi" tvg-logo="https://v3img.voot.com/resizeMedium,w_1090,h_613/v3Storage/assets/jc_sports_horizontal_tray-1695561700528.jpg",JC Sports
https://prod-sports-hin-fa.jiocinema.com/bpk-tv/JC_Sports_24x7_IDC/Fallback/index.m3u8
#EXTINF:-1 tvg-id="2001" group-title="🌟 Jio Cinema" tvg-language="English" tvg-logo="https://v3img.voot.com/resizeMedium,w_1090,h_613/v3Storage/assets/sports_zone_cricket_horizontal-1695032322122.jpg",CricStream
https://prod-sports-hin-fa.jiocinema.com/bpk-tv/JV_SportsHD15_DIG_MOB/Fallback/index.m3u8
#EXTINF:-1 tvg-id="190" group-title="🌟 Jio Cinema" tvg-language="Hindi" tvg-logo="https://v3img.voot.com/resizeMedium,w_1090,h_613/v3Storage/assets/cnbc-awaaz-16x9-1702387934761.jpg",CNBC Awaaz
https://prod-sports-hin-fa.jiocinema.com/bpk-tv/CNBC_Awaaz_voot_MOB/Fallback/index.m3u8
#EXTINF:-1 tvg-id="490" group-title="🌟 Jio Cinema" tvg-language="Gujarati" tvg-logo="https://v3img.voot.com/resizeMedium,w_1090,h_613/v3Storage/assets/whatsapp16x9-1693491956187.jpg",CNBC Bazaar
https://prod-sports-hin-fa.jiocinema.com/bpk-tv/CNBC_Bazaar_voot_MOB/Fallback/index.m3u8
#EXTINF:-1 tvg-id="489" group-title="🌟 Jio Cinema" tvg-language="English" tvg-logo="https://v3img.voot.com/resizeMedium,w_1090,h_613/v3Storage/assets/cnbc18-shereen-bhan-16x9-2-1693479472079.jpg",CNBC Tv 18
https://prod-sports-hin-fa.jiocinema.com/bpk-tv/CNBC_TV18_voot_MOB/Fallback/index.m3u8
#EXTINF:-1 tvg-id="231" group-title="🌟 Jio Cinema" tvg-language="Hindi" tvg-logo="http://jiotv.catchup.cdn.jio.com/dare_images/images/IBN_7.png",News18 India
https://prod-sports-hin-fa.jiocinema.com/bpk-tv/News18_India_voot_MOB/Fallback/index.m3u8
#EXTINF:-1 tvg-id="492" group-title="🌟 Jio Cinema" tvg-language="English" tvg-logo="http://jiotv.catchup.cdn.jio.com/dare_images/images/CNN_NEWS_18.png",CNN NEWS 18
https://prod-sports-hin-fa.jiocinema.com/bpk-tv/CNN_News18_voot_MOB/Fallback/index.m3u8
#EXTINF:-1 tvg-id="615" group-title="🌟 Jio Cinema" tvg-language="Tamil" tvg-logo="http://jiotv.catchup.cdn.jio.com/dare_images/images/News_18_Tamilnadu.png",News18 Tamilnadu
https://prod-sports-hin-fa.jiocinema.com/bpk-tv/News18_Tamil_Nadu_voot_MOB/Fallback/index.m3u8
#EXTINF:-1 tvg-id="232" group-title="🌟 Jio Cinema" tvg-language="Marathi" tvg-logo="http://jiotv.catchup.cdn.jio.com/dare_images/images/IBN_Lokmat.png",News18 Lokmat
https://prod-sports-hin-fa.jiocinema.com/bpk-tv/News18_Lokmat_voot_MOB/Fallback/index.m3u8
#EXTINF:-1 tvg-id="717" group-title="🌟 Jio Cinema" tvg-language="Bengali" tvg-logo="http://jiotv.catchup.cdn.jio.com/dare_images/images/ETV_Bangla_News.png",News18 Bangla News
https://prod-sports-hin-fa.jiocinema.com/bpk-tv/News18_Bangla_voot_MOB/Fallback/index.m3u8
#EXTINF:-1 tvg-id="653" group-title="🌟 Jio Cinema" tvg-language="Kannada" tvg-logo="http://jiotv.catchup.cdn.jio.com/dare_images/images/ETV_Kannada_News.png",News18 Kannada News
https://prod-sports-hin-fa.jiocinema.com/bpk-tv/News18_Kannada_voot_MOB/Fallback/index.m3u8
#EXTINF:-1 tvg-id="620" group-title="🌟 Jio Cinema" tvg-language="Gujarati" tvg-logo="http://jiotv.catchup.cdn.jio.com/dare_images/images/ETV_News_Gujarati.png",News18 Gujarati
https://prod-sports-hin-fa.jiocinema.com/bpk-tv/News18_Gujarati_voot_MOB/Fallback/index.m3u8
#EXTINF:-1 tvg-id="655" group-title="🌟 Jio Cinema" tvg-language="Hindi" tvg-logo="http://jiotv.catchup.cdn.jio.com/dare_images/images/ETV_Haryana_and_HP_News.png",News18 Punjab Haryana
https://prod-sports-hin-fa.jiocinema.com/bpk-tv/News18_Punjab_Haryana_HP_voot_MOB/Fallback/index.m3u8
#EXTINF:-1 tvg-id="696" group-title="🌟 Jio Cinema" tvg-language="Odia" tvg-logo="http://jiotv.catchup.cdn.jio.com/dare_images/images/ETV_News_Oriya.png",News18 Oriya
https://prod-sports-hin-fa.jiocinema.com/bpk-tv/News18_Odia_voot_MOB/Fallback/index.m3u8
#EXTINF:-1 tvg-id="627" group-title="🌟 Jio Cinema" tvg-language="Assamese" tvg-logo="http://jiotv.catchup.cdn.jio.com/dare_images/images/News_18_Assam.png",News18 Assam
https://prod-sports-hin-fa.jiocinema.com/bpk-tv/News18_Assam_North_East_voot_MOB/Fallback/index.m3u8
#EXTINF:-1 tvg-id="965" group-title="🌟 Jio Cinema" tvg-language="Malayalam" tvg-logo="http://jiotv.catchup.cdn.jio.com/dare_images/images/News_18_Kerala.png",News 18 Kerala
https://prod-sports-hin-fa.jiocinema.com/bpk-tv/News18_Kerala_voot_MOB/Fallback/index.m3u8
#EXTINF:-1 tvg-id="531" group-title="🌟 Jio Cinema" tvg-language="Hindi" tvg-logo="http://jiotv.catchup.cdn.jio.com/dare_images/images/ETV_RAJASTHAN.png",News18 RAJASTHAN
https://prod-sports-hin-fa.jiocinema.com/bpk-tv/News18_Rajasthan_voot_MOB/Fallback/index.m3u8
#EXTINF:-1 tvg-id="693" group-title="🌟 Jio Cinema" tvg-language="Bhojpuri" tvg-logo="http://jiotv.catchup.cdn.jio.com/dare_images/images/ETV_BIHAR.png",News18 BIHAR
https://prod-sports-hin-fa.jiocinema.com/bpk-tv/News18_Bihar_Jharkhand_voot_MOB/Fallback/index.m3u8
#EXTINF:-1 tvg-id="529" group-title="🌟 Jio Cinema" tvg-language="Hindi" tvg-logo="http://jiotv.catchup.cdn.jio.com/dare_images/images/ETV_MP.png",News18 MP
https://prod-sports-hin-fa.jiocinema.com/bpk-tv/News18_MP_Chhattisgarh_voot_MOB/Fallback/index.m3u8
#EXTINF:-1 tvg-id="530" group-title="🌟 Jio Cinema" tvg-language="Hindi" tvg-logo="http://jiotv.catchup.cdn.jio.com/dare_images/images/ETV_UP.png",News18 UP
https://prod-sports-hin-fa.jiocinema.com/bpk-tv/News18_UP_Uttarakhand_voot_MOB/Fallback/index.m3u8
#EXTINF:-1 tvg-id="694" group-title="🌟 Jio Cinema" tvg-language="Urdu" tvg-logo="http://jiotv.catchup.cdn.jio.com/dare_images/images/ETV_Urdu.png",News18 JKLH
https://prod-sports-hin-fa.jiocinema.com/bpk-tv/News18_Urdu_voot_MOB/Fallback/index.m3u8

#EXTINF:-1 tvg-id="194389" group-title="🌅 SunNxt" tvg-country="IN" tvg-logo="https://sund-images.sunnxt.com/194389/200x200_SunNeoHD_194389_4cb7110f-1c29-47de-ac4e-2bddf10683cf.png",Sun Neo HD
#KODIPROP:inputstream.adaptive.license_type=org.w3.clearkey
#KODIPROP:inputstream.adaptive.license_key=https://mrking.site/Sun.php?id=194389
https://livestream.sunnxt.com/248c92b73514435686fd72ba325d4008/SunNeoHDB_IN_index.mpd

#EXTINF:-1 tvg-id="194390" group-title="🌅 SunNxt" tvg-country="IN" tvg-logo="https://sund-images.sunnxt.com/194390/200x200_ChuttiTV_194390_a0be6a2e-efc0-4514-98d2-c8cae640dbcc.png",Chutti TV
#KODIPROP:inputstream.adaptive.license_type=org.w3.clearkey
#KODIPROP:inputstream.adaptive.license_key=https://mrking.site/Sun.php?id=194390
https://livestream.sunnxt.com/3ed29d5b01b546eaa05d184cd87535f1/ChuttiTVB_IN_index.mpd

#EXTINF:-1 tvg-id="194408" group-title="🌅 SunNxt" tvg-country="IN" tvg-logo="https://sund-images.sunnxt.com/194408/200x200_SunTV_194408_87e8da9e-7476-4d8e-8aee-fb55105652c1.png",Sun TV
#KODIPROP:inputstream.adaptive.license_type=org.w3.clearkey
#KODIPROP:inputstream.adaptive.license_key=https://mrking.site/Sun.php?id=194408
https://livestream.sunnxt.com/05b5df1221764bca9867054c5e65ee62/SunTVB_IN_index.mpd

#EXTINF:-1 tvg-id="194403" group-title="🌅 SunNxt" tvg-country="IN" tvg-logo="https://sund-images.sunnxt.com/194403/200x200_SunTVHD_194403_8ad3d2a8-5344-4d5c-956c-ccbfb25b2431.png",Sun TV HD
#KODIPROP:inputstream.adaptive.license_type=org.w3.clearkey
#KODIPROP:inputstream.adaptive.license_key=https://mrking.site/Sun.php?id=194403
https://livestream.sunnxt.com/19ee29194c4d4fc286c3e697362e60cd/SunTVHDB_IN_index.mpd

#EXTINF:-1 tvg-id="194409" group-title="🌅 SunNxt" tvg-country="IN" tvg-logo="https://sund-images.sunnxt.com/194409/200x200_KTV_194409_efd11a74-61c7-422d-9fcb-9329003f3459.png",KTV
#KODIPROP:inputstream.adaptive.license_type=org.w3.clearkey
#KODIPROP:inputstream.adaptive.license_key=https://mrking.site/Sun.php?id=194409
https://livestream.sunnxt.com/6ae70edd4c1440379f5311e8fbddc7c1/KTVB_IN_index.mpd

#EXTINF:-1 tvg-id="194405" group-title="🌅 SunNxt" tvg-country="IN" tvg-logo="https://sund-images.sunnxt.com/194405/200x200_KTVHD_194405_1d4448e1-5f79-414b-952b-424044798b43.png",KTV HD
#KODIPROP:inputstream.adaptive.license_type=org.w3.clearkey
#KODIPROP:inputstream.adaptive.license_key=https://mrking.site/Sun.php?id=194405
https://livestream.sunnxt.com/61477b4c8d8d45d5a49e044cc1dffc60/KTVHDB_IN_index.mpd

#EXTINF:-1 tvg-id="194406" group-title="🌅 SunNxt" tvg-country="IN" tvg-logo="https://sund-images.sunnxt.com/194406/200x200_SunMusicHD_194406_2c082383-c774-4e76-a6be-938c48de0227.png",Sun Music HD
#KODIPROP:inputstream.adaptive.license_type=org.w3.clearkey
#KODIPROP:inputstream.adaptive.license_key=https://mrking.site/Sun.php?id=194406
https://livestream.sunnxt.com/d434796d90fa4dc9b7ecfacedbe683f1/SunMusicHDB_IN_index.mpd

#EXTINF:-1 tvg-id="194410" group-title="🌅 SunNxt" tvg-country="IN" tvg-logo="https://sund-images.sunnxt.com/194410/200x200_SunMusic_194410_86c7c8b4-b24b-4a3f-a599-6c3df8bed22b.png",Sun Music
#KODIPROP:inputstream.adaptive.license_type=org.w3.clearkey
#KODIPROP:inputstream.adaptive.license_key=https://mrking.site/Sun.php?id=194410
https://livestream.sunnxt.com/585bb66e95c84ccea3f828c96b3567b5/SunMusicB_IN_index.mpd

#EXTINF:-1 tvg-id="194391" group-title="🌅 SunNxt" tvg-country="IN" tvg-logo="https://sund-images.sunnxt.com/194391/200x200_SunLife_194391_d464515e-939a-4b03-a0d9-29f67b67419b.png",Sun Life
#KODIPROP:inputstream.adaptive.license_type=org.w3.clearkey
#KODIPROP:inputstream.adaptive.license_key=https://mrking.site/Sun.php?id=194391
https://livestream.sunnxt.com/6b79451f54284b3fb680fd717ee008dc/SunLifeB_IN_index.mpd

#EXTINF:-1 tvg-id="194407" group-title="🌅 SunNxt" tvg-country="IN" tvg-logo="https://sund-images.sunnxt.com/194407/200x200_AdithyaTV_194407_5d218a3c-c2ce-47b8-994b-4737e26edfef.png",Adithya TV
#KODIPROP:inputstream.adaptive.license_type=org.w3.clearkey
#KODIPROP:inputstream.adaptive.license_key=https://mrking.site/Sun.php?id=194407
https://livestream.sunnxt.com/4d0eb3cde30247ada4ade679fdfbaf86/AdithyaTVB_IN_index.mpd

#EXTINF:-1 tvg-id="194397" group-title="🌅 SunNxt" tvg-country="IN" tvg-logo="https://sund-images.sunnxt.com/194397/200x200_SuryaTVHD_194397_4c99c17b-92d4-49be-a490-b5958067190a.png",Surya TV HD
#KODIPROP:inputstream.adaptive.license_type=org.w3.clearkey
#KODIPROP:inputstream.adaptive.license_key=https://tsdevil.fun/sun-nxt/ch.key?id=194397
https://livestream.sunnxt.com/d719fad367614ee5baad747822767ad8/SuryaTVHDB_IN_index.mpd

#EXTINF:-1 tvg-id="194398" group-title="🌅 SunNxt" tvg-country="IN" tvg-logo="https://sund-images.sunnxt.com/194398/200x200_SuryaTV_194398_010180e7-db04-4e2a-9b57-c81dfee73222.png",Surya TV
#KODIPROP:inputstream.adaptive.license_type=org.w3.clearkey
#KODIPROP:inputstream.adaptive.license_key=https://mrking.site/Sun.php?id=194398
https://livestream.sunnxt.com/30612a1b269d4a18aa14657641c47515/SuryaTVB_IN_index.mpd

#EXTINF:-1 tvg-id="194385" group-title="🌅 SunNxt" tvg-country="IN" tvg-logo="https://sund-images.sunnxt.com/194385/200x200_SuryaMovies_194385_0a1fbf90-a86a-4580-bdd8-36c6d1826c46.png",Surya Movies
#KODIPROP:inputstream.adaptive.license_type=org.w3.clearkey
#KODIPROP:inputstream.adaptive.license_key=https://mrking.site/Sun.php?id=194385
https://livestream.sunnxt.com/e24ee14c395945bd8ccb065e1bce8b9b/SuryaMoviesB_IN_index.mpd

#EXTINF:-1 tvg-id="194338" group-title="🌅 SunNxt" tvg-country="IN" tvg-logo="https://sund-images.sunnxt.com/194338/200x200_SuryaMusic_194338_8c3cb980-e460-478e-9b60-18b5550a2596.png",Surya Music
#KODIPROP:inputstream.adaptive.license_type=org.w3.clearkey
#KODIPROP:inputstream.adaptive.license_key=https://mrking.site/Sun.php?id=194338
https://livestream.sunnxt.com/8c2352ff54954e7b9a4188045dcf3b27/SuryaMusicB_IN_index.mpd

#EXTINF:-1 tvg-id="193251" group-title="🌅 SunNxt" tvg-country="IN" tvg-logo="https://sund-images.sunnxt.com/193251/200x200_SuryaComedy_193251_1c2fd207-acad-4096-9bc4-d207375ae0af.png",Surya Comedy
#KODIPROP:inputstream.adaptive.license_type=org.w3.clearkey
#KODIPROP:inputstream.adaptive.license_key=https://mrking.site/Sun.php?id=193251
https://livestream.sunnxt.com/6505e922bf164423ad122f404747356a/SuryaComedyB_IN_index.mpd

#EXTINF:-1 tvg-id="194348" group-title="🌅 SunNxt" tvg-country="IN" tvg-logo="https://sund-images.sunnxt.com/194348/200x200_KochuTV_194348_f8187f4e-60c3-4727-9cdf-ecac24bff645.png",Kochu TV
#KODIPROP:inputstream.adaptive.license_type=org.w3.clearkey
#KODIPROP:inputstream.adaptive.license_key=https://mrking.site/Sun.php?id=194348
https://livestream.sunnxt.com/1893b9ab790747cb80a584873a608dcb/KochuTVB_IN_index.mpd

#EXTINF:-1 tvg-id="194387" group-title="🌅 SunNxt" tvg-country="IN" tvg-logo="https://sund-images.sunnxt.com/194387/200x200_SunMarathi_194387_70b805b7-4686-49a4-8617-f5abd975b3fe.png",Sun Marathi
#KODIPROP:inputstream.adaptive.license_type=org.w3.clearkey
#KODIPROP:inputstream.adaptive.license_key=https://mrking.site/Sun.php?id=194387
https://livestream.sunnxt.com/b0aacde03b744564870634ecb10e8a31/SunMarathiB_IN_index.mpd

#EXTINF:-1 tvg-id="194399" group-title="🌅 SunNxt" tvg-country="IN" tvg-logo="https://sund-images.sunnxt.com/194399/200x200_UdayaTVHD_194399_70d9e991-2ea2-4f5a-89b0-13489fe3a482.png",Udaya TV HD
#KODIPROP:inputstream.adaptive.license_type=org.w3.clearkey
#KODIPROP:inputstream.adaptive.license_key=https://tsdevil.fun/sun-nxt/ch.key?id=194399
https://livestream.sunnxt.com/a8d28f18944c4946ad7133938860e7cf/UdayaTVHDB_IN_index.mpd

#EXTINF:-1 tvg-id="193239" group-title="🌅 SunNxt" tvg-country="IN" tvg-logo="https://sund-images.sunnxt.com/193239/200x200_UdayaTV_193239_ec435a3b-aad0-44e1-9c70-fc572199add9.png",Udaya TV
#KODIPROP:inputstream.adaptive.license_type=org.w3.clearkey
#KODIPROP:inputstream.adaptive.license_key=https://mrking.site/Sun.php?id=193239
https://livestream.sunnxt.com/e2f36b5d0be74780a041a8f5b65bc7e6/UdayaTVB_IN_index.mpd

#EXTINF:-1 tvg-id="194397" group-title="🌅 SunNxt" tvg-country="IN" tvg-logo="https://sund-images.sunnxt.com/194386/200x200_UdayaMovies_194386_b30f865a-0108-4c83-875c-cdf29e952582.png",Udaya Movies
#KODIPROP:inputstream.adaptive.license_type=org.w3.clearkey
#KODIPROP:inputstream.adaptive.license_key=https://mrking.site/Sun.php?id=194397
https://livestream.sunnxt.com/1c02547243c041eea5dab1c343018e90/UdayaMoviesB_IN_index.mpd

#EXTINF:-1 tvg-id="194401" group-title="🌅 SunNxt" tvg-country="IN" tvg-logo="https://sund-images.sunnxt.com/194401/200x200_UdayaMusic_194401_a075b7ca-6045-482a-90c3-a544cf6c3647.png",Udaya Music
#KODIPROP:inputstream.adaptive.license_type=org.w3.clearkey
#KODIPROP:inputstream.adaptive.license_key=https://mrking.site/Sun.php?id=194401
https://livestream.sunnxt.com/8034b7519d6a4ab8929aa4279fda1f29/UdayaMusicB_IN_index.mpd

#EXTINF:-1 tvg-id="194400" group-title="🌅 SunNxt" tvg-country="IN" tvg-logo="https://sund-images.sunnxt.com/194400/200x200_UdayaComedy_194400_3f736966-dccc-4594-94cd-62e18c85d066.png",Udaya Comedy
#KODIPROP:inputstream.adaptive.license_type=org.w3.clearkey
#KODIPROP:inputstream.adaptive.license_key=https://mrking.site/Sun.php?id=194400
https://livestream.sunnxt.com/8a3d3d8d679b4f9f83a8305b4ead0644/UdayaComedyB_IN_index.mpd

#EXTINF:-1 tvg-id="194347" group-title="🌅 SunNxt" tvg-country="IN" tvg-logo="https://sund-images.sunnxt.com/194347/200x200_ChintuTV_194347_59b6772c-5303-4eb8-9538-2b99f3956eed.png",Chintu TV
#KODIPROP:inputstream.adaptive.license_type=org.w3.clearkey
#KODIPROP:inputstream.adaptive.license_key=https://tsdevil.fun/sun-nxt/ch.key?id=194347
https://livestream.sunnxt.com/ed4c67ad957644b69361651d9101107e/ChintuTVB_IN_index.mpd

#EXTINF:-1 tvg-id="194396" group-title="🎭 SunNxt - Telugu" tvg-country="IN" tvg-logo="https://sund-images.sunnxt.com/194396/200x200_GeminiTV_194396_068bbb03-8548-4cff-af0b-556f5a2e2128.png",Gemini TV
#KODIPROP:inputstream.adaptive.license_type=org.w3.clearkey
#KODIPROP:inputstream.adaptive.license_key=https://mrking.site/Sun.php?id=194396
https://livestream.sunnxt.com/a1a61fa1811c4d20a5c2d5e14cdc0cd2/GeminiTVB_IN_index.mpd

#EXTINF:-1 tvg-id="194392" group-title="🎭 SunNxt - Telugu" tvg-country="IN" tvg-logo="https://sund-images.sunnxt.com/194392/200x200_GeminiTVHD_194392_0a146256-5869-40c5-89de-2fbb9ad6b0ce.png",Gemini TV HD
#KODIPROP:inputstream.adaptive.license_type=org.w3.clearkey
#KODIPROP:inputstream.adaptive.license_key=https://mrking.site/Sun.php?id=194392
https://livestream.sunnxt.com/e778d9c98488494b9c9b38f9c48b63ec/GeminiTVHDB_IN_index.mpd

#EXTINF:-1 tvg-id="194384" group-title="🎭 SunNxt - Telugu" tvg-country="IN" tvg-logo="https://sund-images.sunnxt.com/194384/200x200_GeminiMovies_194384_abbba9d4-509e-46d5-8808-59efe178a4c2.png",Gemini Movies
#KODIPROP:inputstream.adaptive.license_type=org.w3.clearkey
#KODIPROP:inputstream.adaptive.license_key=https://mrking.site/Sun.php?id=194384
https://livestream.sunnxt.com/6a59979ff0044fd3b6e0cb85d6f44432/GeminiMoviesB_IN_index.mpd

#EXTINF:-1 tvg-id="192537" group-title="🎭 SunNxt - Telugu" tvg-country="IN" tvg-logo="https://sund-images.sunnxt.com/192537/200x200_GeminiMoviesHD_192537_b5634337-a7cf-4e44-9643-8df747dde8ed.png",Gemini Movies HD
#KODIPROP:inputstream.adaptive.license_type=org.w3.clearkey
#KODIPROP:inputstream.adaptive.license_key=https://mrking.site/Sun.php?id=192537
https://livestream.sunnxt.com/ec0d4961a002442295f91efc9d675c9d/GeminiMoviesHDB_IN_index.mpd

#EXTINF:-1 tvg-id="194393" group-title="🎭 SunNxt - Telugu" tvg-country="IN" tvg-logo="https://sund-images.sunnxt.com/194393/200x200_GeminiMusicHD_194393_38918c7e-413e-46a0-bae9-4b3b766fe6d7.png",Gemini Music HD
#KODIPROP:inputstream.adaptive.license_type=org.w3.clearkey
#KODIPROP:inputstream.adaptive.license_key=https://mrking.site/Sun.php?id=194393
https://livestream.sunnxt.com/6a6520e446604c6e9840e5bf3a3a7d95/GeminiMusicHDB_IN_index.mpd

#EXTINF:-1 tvg-id="194395" group-title="🎭 SunNxt - Telugu" tvg-country="IN" tvg-logo="https://sund-images.sunnxt.com/194395/200x200_GeminiMusic_194395_9b2cc3b0-9732-4bf8-9efc-fed04d9bc9df.png",Gemini Music
#KODIPROP:inputstream.adaptive.license_type=org.w3.clearkey
#KODIPROP:inputstream.adaptive.license_key=https://mrking.site/Sun.php?id=194395
https://livestream.sunnxt.com/52b94f70c6e64692b2497f5023b629cd/GeminiMusicB_IN_index.mpd

#EXTINF:-1 tvg-id="194394" group-title="🎭 SunNxt - Telugu" tvg-country="IN" tvg-logo="https://sund-images.sunnxt.com/194394/200x200_GeminiComedy_194394_0fe7c915-5f33-4c6f-909b-3d8d45f92f67.png",Gemini Comedy
#KODIPROP:inputstream.adaptive.license_type=org.w3.clearkey
#KODIPROP:inputstream.adaptive.license_key=https://mrking.site/Sun.php?id=194394
https://livestream.sunnxt.com/167c40e9521b470b87b4cf921fd0e146/GeminiComedyB_IN_index.mpd

#EXTINF:-1 tvg-id="194337" group-title="🎭 SunNxt - Telugu" tvg-country="IN" tvg-logo="https://sund-images.sunnxt.com/194337/200x200_GeminiLife_194337_e1145455-d580-4b95-8f35-73e48e199533.png",Gemini Life
#KODIPROP:inputstream.adaptive.license_type=org.w3.clearkey
#KODIPROP:inputstream.adaptive.license_key=https://tsdevil.fun/sun-nxt/ch.key?id=194337
https://livestream.sunnxt.com/a4b4f71a8b4344f3a280e906657a517a/GeminiLifeB_IN_index.mpd

#EXTINF:-1 tvg-id="194346" group-title="🎭 SunNxt - Telugu" tvg-country="IN" tvg-logo="https://sund-images.sunnxt.com/194346/200x200_KushiTV_194346_21645eb7-43c4-4721-89bf-b2658d856251.png",Kushi TV
#KODIPROP:inputstream.adaptive.license_type=org.w3.clearkey
#KODIPROP:inputstream.adaptive.license_key=https://tsdevil.fun/sun-nxt/ch.key?id=194346
https://livestream.sunnxt.com/4a736d41608849758a0aed36949ded30/KushiTVB_IN_index.mpd

#EXTINF:-1 tvg-id="194388" group-title="🌅 SunNxt" tvg-country="IN" tvg-logo="https://sund-images.sunnxt.com/194388/200x200_SunBangla_194388_9c4b5c51-1554-4507-83a8-7b54f31a8967.png",Sun Bangla
#KODIPROP:inputstream.adaptive.license_type=org.w3.clearkey
#KODIPROP:inputstream.adaptive.license_key=https://tsdevil.fun/sun-nxt/ch.key?id=194388
https://livestream.sunnxt.com/bf76ee92dd01473bb2eb57d137294484/SunBanglaB_IN_index.mpd
EOT;
echo $m3u8PlaylistFile . $additionalEntries;
?>
