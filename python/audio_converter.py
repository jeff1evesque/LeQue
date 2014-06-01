#!/usr/bin/python

import sys
import pocketsphinx

if __name__ == '__main__':

  hmdir = '/usr/share/pocketsphinx/model/hmm/wsj1'
  lmdir = '/usr/share/pocketsphinx/model/lm/wsj/wlist5o.3e-7.vp.tg.lm.DMP'
  dictd = '/usr/share/pocketsphinx/model/lm/wsj/wlist5o.dic'
  wavfile = sys.argv[1]

  speechRec = pocketsphinx.Decoder(hmm = hmdir, lm = lmdir, dict = dictd)
  wavFile = file(wavfile, 'rb')
  speechRec.decode_raw(wavFile)
  result = speechRec.get_hyp()

  print result
