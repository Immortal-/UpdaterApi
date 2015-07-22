using System;
using System.Text;
using System.Runtime.Serialization;

namespace UpdaterModule
{
    [DataContract]
    public class ClientFile
    {
        [DataMember(Name = "id")]
        public int Id { get; set; }


        [DataMember(Name = "name")]
        public string Name { get; set; }


        [DataMember(Name = "version")]
        public string Version { get; set; }


        [DataMember(Name = "date_submitted")]
        public string DateSubmitted { get; set; }


        [DataMember(Name = "hash")]
        public string Hash { get; set; }


        [DataMember(Name = "notes")]
        public string Notes { get; set; }


        [DataMember(Name = "download_link")]
        public string DownloadLink { get; set; }
    }
}