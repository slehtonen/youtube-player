#!/usr/bin/python
import sys, os
import subprocess
import signal
import urllib
import urllib2
import time
from subprocess import Popen, PIPE

# fix signal error caused by omxplayer
from signal import signal, SIGPIPE, SIG_DFL
signal(SIGPIPE,SIG_DFL) 

moviePlaying = False
playProcess = "";
url = ""

def getUrl(youtubeUrl):

   try:
      proc = subprocess.Popen("youtube-dl -g " + youtubeUrl, shell=True, stdout=subprocess.PIPE)
      (out, err) = proc.communicate()
      url = out.replace('\n', '')
      return url

   except KeyboardInterrupt:
      print "Exit"
      exit()

def postStuffAndReturnUrl(values):
   postUrl = 'http://localhost/player/Main.php'

   data = urllib.urlencode(values)
   req = urllib2.Request(postUrl, data)
   response = urllib2.urlopen(req)
   return response.read()

def checkForImmediatePlay():
   values = {'m' : 'playnow'}
   return postStuffAndReturnUrl(values)

def playNextInQueue():
  values = {'m' : 'next'}
  return postStuffAndReturnUrl(values)

while True:

   url = checkForImmediatePlay()

   if(url != "e"):
      if (moviePlaying): 
         print "quit"
         playProcess.stdin.write('q')
         moviePlaying = False

   if (moviePlaying == False):

      if (url == "e"):
         url = playNextInQueue()

      if (url == "e"): 
         print "continue"
         time.sleep(2)
         continue

      print "play"

      url = getUrl(url)

      try:
         command1='omxplayer','-o', 'hdmi', url
         playProcess = subprocess.Popen(command1, stdin=PIPE, stderr=PIPE, preexec_fn=os.setsid)

      except KeyboardInterrupt:
         playProcess.stdin.write('q')

         print "Exit"
         exit()
         os.killpg(playProcess.pid, signal.SIGTERM)

      moviePlaying = True
 
   if(playProcess.poll() != None):
      print "movie stopped"
      moviePlaying = False

   time.sleep(2)
