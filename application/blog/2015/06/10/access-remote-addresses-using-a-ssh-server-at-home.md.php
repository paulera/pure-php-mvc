# Access remote addresses, using a SSH server at home

Sometimes you need to use remote servers from home, but there is just no way to have them expose to the web. I guess the most usual situation is when you want to have access to your computer at work, which is behind the company network + firewalls and, despite it can see the web, it can not have external visibility. But there is a workaround using SSH which, properly setup, can be as safe as a VPN, with advantages. This solution is much more portable, since the VPN works at the operating system level, when SSH clients only at application level, usually using [Putty](http://www.chiark.greenend.org.uk/~sgtatham/putty/download.html).

I searched a lot on internet for a clear and straight approach, but it was not that easy to find. So I decided to wrote myself this article, my way, covering the following situation:

* I use Windows at both work and home.
* I have resources at work which I want to see from home (eg. a SQL Server, a web server running on my workstation there or even a Remote Desktop).
* I can not have more than a normal putty client running at work. No way to expose IPs or whatever, for obvious reasons.
* I can have a Linux installation running a SSH server at home (Raspberry PI, old desktop or a virtual machine).
* I can expose my SSH server to the web, using my router's port forwarding options.

[ Skip all the bla-di-bla and take me straight to the point - although it worth reading! ]

# Is SSH safe enough?