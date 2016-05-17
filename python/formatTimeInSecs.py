def formatTimeInSec(timeInSec):
  if timeInSec >= 3600: #time is one hour and above
    time = hrMinSec(timeInSec)

  elif timeInSec >= 60:#time is a minute and above but not upto one hour
    time = minuteAndSec(timeInSec)

  else: #it is not upto a minute
    time = str(timeInSec) + "s"

  return time


#function will be called only if time is a minute or more but not upto an hr
def minuteAndSec(timeInSec):
  minute = timeInSec/60 #get the number of minutes

  minstr = str(minute) + "m"

  sec = timeInSec % 60 #get the number of secs (if any)

  if sec:
    secstr = str(sec) + "s"

  else:
    secstr = ""

  time = minstr+" "+secstr

  return time


#function will be called only if time is an hour or more
def hrMinSec(timeInSec):
  hr = timeInSec/3600

  if hr:
    hrstr = str(hr) + "h"

  else:
    hrstr = ""

  secsleft = timeInSec % 3600

  if secsleft < 60:
    minstr = "" #set min string as empty since the ses left is not up to a minute

    if secsleft > 0: #only add seconds if there is at least one sec left
      secstr = str(secsleft) + "s"
    else:
      secstr = ""

    minandsecstr = minstr + " " + secstr #concatenate the two strings

  else: #if the number of secs left is upto a minute or more
    minandsecstr = minuteAndSec(secsleft)

  return hrstr+" "+minandsecstr



while True:
  print("Input time (in seconds) or letter q to quit")
  inputtedTime = input()

  if inputtedTime == "q":
    break

  else:
    print(formatTimeInSec(inputtedTime))
