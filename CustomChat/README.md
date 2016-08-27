CustomChat v_2.4.1 ...
============
## Update work With : PurePerms / MassiveEconomy / KillChat 

###### • Added option in the chat Format


###### • This Plugin uses the New API. You can't install it on old versions of PocketMine.

###### Source : https://github.com/Praxthisnovcht/CustomChat




#Features


***•SetPrefix | DefPrefix | Nick***


***•Mute | Unmute***


***•DisableChat | EnableChat***


***•CustomJoin Format < Read Documentation***


***•Custom Chat-Format < Read Documentation***


***•Support Plugins For Use In Chat-Format***


#Read documentation
######•Support PurePerms ( MultiWorld )
######•Support FactionsPro
######•Support EconomyAPI
######•Support KillChat
######•Support MassiveEconomy


***•For other inquiries, Please open an issue***



#  Commands
```yaml
---
/setprefix "sets prefix for player"

/delprefix "set player's prefix to default"

/defprefix "sets default prefix for new players"

/setnick "sets player's nick"

/delnick "returns players's real name"

/mute "mute player from chat"

/unmute "unmute player from chat"

/disablechat "disable chat for all players"

/enablechat "enable chat for all player"

/customchat "any authorization"[/HTML]
...
```


***#How do I install this??***


***#Drop in in your servers plugin folder!***


***how to use FactionsPro with CustomChat ?***




######You only need to place the two plugins in the plugins folder and CustomChat charge it needs to :


**Configuration (config.yml):**
```yaml
---
chat-format: '{WORLD_NAME}:[{FACTION}][{PREFIX}]<{DISPLAY_NAME}> {MESSAGE}'

// The format cat can be changed according to your desire.

if-player-has-no-faction: NoFaction

// It will display "NoFaction" when you will not have Faction.

// It will be useless if FactionsPro is not loaded

enable-formatter: true

// To activate the format or not, the goal is to let the plugin enabled

disablechat: false

// We can give people the right to speak on the server,

default-player-prefix: Default

// It is chosen to be the Prefix by default.
...
```
***#how to MassiveEconomy with CustomChat ?***


***First you have to download and MassiveEconomy CustomChat.***


***Start the server.***

**Configuration (config.yml):**
```yaml
---
chat-format: '{WORLD_NAME}:[{PurePerms}][{PREFIX}]<{DISPLAY_NAME}> {MESSAGE}'

if-player-has-no-faction: NoFaction

if-player-has-no-job: unemployed

enable-formatter: true

disablechat: false

default-player-prefix: Default

CustomChat options: '{Kills} | {Deaths} |  [{Money}$]' # This is the code for MassiveEconomy

CustomJoin: '@Player joined the server ! Iksaku is Awesome'

CustomLeave: '@Player leave the server ! Iksaku is Awesome'

...
...
```

######You must copy the piece of code that is shown above and copy it to the Chat-Format or as you want.

######Keeping tags

**Configuration (config.yml):**
```yaml
---
chat-format: '{WORLD_NAME}:[{Money}$][{PurePerms}][{PREFIX}]<{DISPLAY_NAME}> {MESSAGE}'

if-player-has-no-faction: NoFaction

if-player-has-no-job: unemployed

enable-formatter: true

disablechat: false

default-player-prefix: Default

CustomChat options: '{Kills} | {Deaths} |  [{Money}$]'

CustomJoin: '@Player joined the server ! Iksaku is Awesome'

CustomLeave: '@Player leave the server ! Iksaku is Awesome'
...

```

***#Here you must restart your server to be able to see your money when you talk !***


#how to CustomJoin Options with CustomChat ?


***The use is very simple. He is staying in the mode of CustomMessage.***

***You just have to change the lines below to change the message of connection or disconnection***



**Configuration (config.yml):**
```yaml
---
CustomJoin: '@Player joined the server ! Iksaku is Awesome'
CustomLeave: '@Player leave the server ! Iksaku is Awesome'
...
```


***######The options available in version 1.3.1 is only !****
**Configuration**
```yaml
---
@Player = DisplayName

@Faction = your faction (need FactionsPro)[/CODE]
...
```

######Chat format change

**Configuration**
```yaml
---
chat-format: '{WORLD_NAME}:[{PurePerms}][{PREFIX}]<{DISPLAY_NAME}> {MESSAGE}'
...
```
######Displays the name or the world you are.
**Configuration**
```yaml
---
chat-format: '{WORLD_NAME}'
...
```
######Displays the name of your faction  ( Use FactionsPro )
**Configuration**
```yaml
---
chat-format: '{FACTION}'
...
```
######Displays the grade with PurePerms
**Configuration**
```yaml
---
chat-format: '{PurePerms}'
...
```
######Displays the selected prefix or by default
**Configuration**
```yaml
---
chat-format: '{PREFIX}'
...
```
######Displays your Name
**Configuration**
```yaml
---
chat-format: '{DISPLAY_NAME}'
...
```
######Displays Message
**Configuration**
```yaml
---
chat-format: '{MESSAGE}'
...
```
######You can change the order of the Chat-Format


****It is possible to do work on multiple online !***

**Configuration**
```yaml
\n

```

**Configuration**
```yaml
---
chat-format: '{WORLD_NAME}:[{FACTION}][{PurePerms}][{PREFIX}]<{DISPLAY_NAME}> \n{MESSAGE}'
...
```
**#Permissions**
```yaml
---
setprefix:

  description: "sets prefix for player"

  permission: customchat.plugin.setprefix

defprefix:

  description: "sets default prefix for new players"

  permission: customchat.plugin.defprefix

delprefix:

  description: "set player's prefix to default"

  permission: customchat.plugin.delprefix

setnick:

  description: "sets player's nick"

  permission: customchat.plugin.setnick

delnick:

  description: "returns players's real name"

  permission: customchat.plugin.delnick

mute:

  description: "mute player from chat"

  permission: customchat.plugin.mute

unmute:

  description: "unmute player from chat"

  permission: customchat.plugin.unmute

disablechat:

  description: "disable chat for all players"

  permission: customchat.plugin.offchat

enablechat:

  description: "enable chat for all player"

  permission: customchat.plugin.onchat

...
```










