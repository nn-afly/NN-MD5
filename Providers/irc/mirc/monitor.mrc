
set %var ""

on $*:text:/\b/Si:#gp.pre:{
  tokenize 32 $strip($1-) {
    if (.: isin $1-) {
     if ($6- != [) {
      %var = $6
      /sockopen p2pnetgppre YOURDOMAINORIP 80
      }
    }
  }
}


on $*:text:/\b/Si:#p2p-nl-pre:{
  tokenize 32 $strip($1-) {
    if ($7- != [) {
      %var = $7
      /sockopen p2pnetp2pnlpre YOURDOMAINORIP 80
    }
  }

}



on *:SOCKOPEN:p2pnetgppre: { 
  echo -s *** $sockname was just opened, Retrieving /preinsert/  $+ %var
  ; $sockname stands for the name of the socket, i.e. http 
  sockwrite -n $sockname GET /preinsert/ $+ %var HTTP/1.0 
  sockwrite $sockname $crlf 
  ; sent data to http socket requesting the file /preinsert/sock.nfo 
  ; you may sometimes get a file not found message even though you know 
  ; it exists. This is usually because you need to specify a Host: or Referer: 
}
on *:SOCKCLOSE:p2pnetgppre: { 
  echo -s *** $sockname just closed 
}

on *:SOCKREAD:p2pnetgppre: { 
  if ($sockerr > 0) return 
  :nextread 
  sockread %temp 
  ; read the data coming from the socket 
  if ($sockbr == 0) return 
  ; if i've read all the data, stop 
  if (%temp) { echo %temp } 
  ; if there was stuff received from the socket, then echo it 
  goto nextread 
}




on *:SOCKOPEN:p2pnetp2pnlpre: { 
  echo -s *** $sockname was just opened, Retrieving /preinsert/  $+ %var
  ; $sockname stands for the name of the socket, i.e. http 
  sockwrite -n $sockname GET /preinsert/ $+ %var HTTP/1.0 
  sockwrite $sockname $crlf 
  ; sent data to http socket requesting the file /preinsert/sock.nfo 
  ; you may sometimes get a file not found message even though you know 
  ; it exists. This is usually because you need to specify a Host: or Referer: 
}
on *:SOCKCLOSE:p2pnetp2pnlpre: { 
  echo -s *** $sockname just closed 
}

on *:SOCKREAD:p2pnetp2pnlpre: { 
  if ($sockerr > 0) return 
  :nextread 
  sockread %temp 
  ; read the data coming from the socket 
  if ($sockbr == 0) return 
  ; if i've read all the data, stop 
  if (%temp) { echo %temp } 
  ; if there was stuff received from the socket, then echo it 
  goto nextread 
}
